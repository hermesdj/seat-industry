<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Seat\HermesDj\Industry\Helpers\Industry\BuildPlan;
use Seat\HermesDj\Industry\Helpers\Industry\Skills\IndustrySkillsHelper;
use Seat\HermesDj\Industry\Helpers\OrderHelper;
use Seat\HermesDj\Industry\Models\Deliveries\Delivery;
use Seat\HermesDj\Industry\Models\Deliveries\DeliveryItem;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\HermesDj\Industry\Models\Orders\OrderItem;
use Seat\Web\Http\Controllers\Controller;

class IndustryDeliveryController extends Controller
{
    private const MaxDeliveryCodeLength = 6;

    public function myUnfulfilledDeliveries(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $deliveries = Delivery::myUnfulfilledDeliveries()->get();

        return view('seat-industry::deliveries.myUnfulfilledDeliveries', compact('deliveries'));
    }

    public function allDeliveries(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $deliveries = Delivery::allDeliveries()->get();

        return view('seat-industry::deliveries.allDeliveries', compact('deliveries'));
    }

    public function deliveryDetails(Delivery $delivery, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        return view('seat-industry::deliveries.details', compact('delivery'));
    }

    public function deliveryRavworksDetails(Delivery $delivery): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $buildPlan = new BuildPlan($delivery->order);
        if ($delivery->order) {
            $buildPlan->computeBuildPlanForDelivery($delivery);
            $buildPlan->computeOrderStocks(auth()->user());
        }

        return view('seat-industry::deliveries.ravworks', compact('delivery', 'buildPlan'));
    }

    public function deliveryBuildPlan(Delivery $delivery): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('seat-industry::deliveries.buildPlan', compact('delivery'));
    }

    public function prepareDelivery(Order $order, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $validated = $request->validate([
            'fill' => 'boolean',
        ]);

        Gate::authorize('seat-industry.create_deliveries');

        $corpIds = auth()->user()->characters->map(function ($char) {
            return $char->affiliation->corporation_id;
        });

        $isCorp = $corpIds->some(function ($id) use ($order) {
            return $id == $order->corp_id;
        });

        if ($order->corp_id != null && !$isCorp) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_not_allowed_to_create_delivery'));

            return redirect()->route('seat-industry.orderDetails', ['order' => $order->id]);
        }

        $items = $order->items->filter(function ($item) {
            return $item->availableQuantity() > 0;
        });

        $items = $items->map(function ($item) {
            $item->deliveredQuantity = 0;

            return $item;
        });

        if (isset($validated['fill']) && $validated['fill']) {
            $items = $items->map(function ($item) {
                $item->deliveredQuantity = $item->availableQuantity();

                return $item;
            });
        }

        IndustrySkillsHelper::computeManufacturingSkillsForOrderItems(auth()->user(), $items);

        return view('seat-industry::prepareDelivery', compact('order', 'items'));
    }

    public function addDelivery(Order $order, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:0',
        ]);

        Gate::authorize('seat-industry.create_deliveries');

        if ($order->is_repeating) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_delivery_not_assignable_to_repeating_order'));

            return redirect()->route('seat-industry.orders');
        }

        $quantities = $validated['quantities'];

        $delivery = new Delivery;
        $delivery->delivery_code = OrderHelper::generateRandomString(self::MaxDeliveryCodeLength);
        $delivery->order_id = $order->id;
        $delivery->user_id = auth()->user()->id;
        $delivery->completed = false;
        $delivery->accepted = now();

        $deliveryItems = [];
        $totalQuantity = 0;

        foreach ($quantities as $id => $quantity) {
            $item = OrderItem::find($id);
            if ($item->order_id != $order->id) {
                $request->session()->flash('error', trans('seat-industry::ai-common.error_item_order_id_does_not_match'));

                return redirect()->back();
            }

            if ($item->assignedQuantity() + $quantity > $item->quantity) {
                $request->session()->flash('error', trans('seat-industry::ai-common.error_too_much_quantity_provided'));

                return redirect()->back();
            }

            if ($quantity > 0) {
                $model = new DeliveryItem;
                $model->order_id = $order->id;
                $model->order_item_id = $item->id;
                $model->completed = false;
                $model->accepted = now();
                $model->quantity_delivered = $quantity;

                $totalQuantity += $quantity;
                $deliveryItems[] = $model;
            }
        }

        if (empty($deliveryItems)) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_delivery_not_assignable_to_repeating_order'));

            return redirect()->back();
        }

        $delivery->quantity = $totalQuantity;
        $delivery->save();

        foreach ($deliveryItems as $deliveryItem) {
            $deliveryItem->delivery_id = $delivery->id;
            $deliveryItem->save();
        }

        $request->session()->flash('success', trans('seat-industry::ai-deliveries.delivery_creation_success'));

        return redirect()->route('seat-industry.deliveryDetails', ['delivery' => $delivery->id]);
    }

    public function setDeliveryState(Delivery $delivery, Request $request): RedirectResponse
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        Gate::authorize('seat-industry.modify-delivery', $delivery);

        if ($request->completed) {
            $delivery->completed_at = now();
            $delivery->completed = true;
        } else {
            $delivery->completed_at = null;
            $delivery->completed = false;
        }

        $delivery->save();

        // Mark all delivery items as completed too
        DeliveryItem::where('delivery_id', $delivery->id)
            ->update(['completed' => $delivery->completed, 'completed_at' => $delivery->completed_at]);

        return redirect()->back();
    }

    public function setDeliveryItemState(Delivery $delivery, DeliveryItem $item, Request $request): RedirectResponse
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        Gate::authorize('seat-industry.modify-delivery', $delivery);

        if ($request->completed) {
            $item->completed_at = now();
            $item->completed = true;
        } else {
            $item->completed_at = null;
            $item->completed = false;
        }
        $item->save();

        $totalDelivered = DeliveryItem::where('delivery_id', $delivery->id)
            ->where('completed', true)
            ->sum('quantity_delivered');

        if ($totalDelivered < $delivery->totalQuantity()) {
            $delivery->completed_at = null;
            $delivery->completed = false;
        } else {
            $delivery->completed_at = now();
            $delivery->completed = true;
        }

        $delivery->save();

        return redirect()->back();
    }

    public function deleteDelivery(Delivery $delivery, Request $request): RedirectResponse
    {
        Gate::authorize('seat-industry.modify-delivery', $delivery);

        $delivery->delete();

        $request->session()->flash('success', trans('seat-industry::ai-deliveries.delivery_removal_success'));

        return redirect()->route('seat-industry.orderDetails', ['order' => $delivery->order_id]);
    }

    public function deleteDeliveryItem(Delivery $delivery, DeliveryItem $item, Request $request): RedirectResponse
    {
        Gate::authorize('seat-industry.modify-delivery', $delivery);

        $item->delete();

        $request->session()->flash('success', trans('seat-industry::ai-deliveries.delivery_item_removal_success'));

        $delivery->quantity = $delivery->totalQuantity();
        $delivery->save();

        return redirect()->back();
    }
}
