<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Seat\HermesDj\Industry\Helpers\OrderHelper;
use Seat\HermesDj\Industry\Models\Deliveries\Delivery;
use Seat\HermesDj\Industry\Models\Deliveries\DeliveryItem;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\HermesDj\Industry\Models\Orders\OrderItem;
use Seat\Web\Http\Controllers\Controller;

class IndustryDeliveryController extends Controller
{
    private const MaxDeliveryCodeLength = 6;

    public function deliveries(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user_id = auth()->user()->id;

        $deliveries = Delivery::with('order')->where('user_id', $user_id)->get();

        return view('seat-industry::deliveries', compact('deliveries'));
    }

    public function deliveryDetails($id, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $delivery = Delivery::with('deliveryItems')->find($id);

        if (! $delivery) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_delivery_not_found'));

            return redirect()->back();
        }

        return view('seat-industry::deliveryDetails', compact('delivery'));
    }

    public function prepareDelivery($orderId, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $order = Order::find($orderId);
        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->route('Industry.orderDetails', ['id' => $orderId]);
        }

        if ($order->corporation != null && $order->corporation->corporation_id != auth()->user()->main_character->affiliation->corporation_id) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_not_allowed_to_create_delivery'));

            return redirect()->route('Industry.orderDetails', ['id' => $orderId]);
        }

        $items = $order->items->filter(function ($item) {
            return $item->availableQuantity() > 0;
        });

        return view('seat-industry::prepareDelivery', compact('order', 'items'));
    }

    public function addDelivery($orderId, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:0',
        ]);

        $order = Order::find($orderId);
        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->back();
        }

        if ($order->is_repeating) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_delivery_not_assignable_to_repeating_order'));

            return redirect()->route('Industry.orders');
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
            if ($item->order_id != $orderId) {
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

        return redirect()->route('Industry.deliveryDetails', ['id' => $delivery->id]);
    }

    public function setDeliveryState($deliveryId, Request $request): RedirectResponse
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        $delivery = Delivery::find($deliveryId);

        Gate::authorize('seat-industry.same-user', $delivery->user_id);

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

    public function setDeliveryItemState($deliveryId, $itemId, Request $request): RedirectResponse
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        $delivery = Delivery::find($deliveryId);
        $item = DeliveryItem::find($itemId);

        Gate::authorize('seat-industry.same-user', $delivery->user_id);

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

    public function deleteDelivery($deliveryId, Request $request): RedirectResponse
    {
        $delivery = Delivery::find($deliveryId);

        if ($delivery) {
            Gate::authorize('seat-industry.same-user', $delivery->user_id);

            if ($delivery->completed) {
                Gate::authorize('Industry.admin');
            }

            $delivery->delete();

            $request->session()->flash('success', trans('seat-industry::ai-deliveries.delivery_removal_success'));
        } else {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_delivery_not_found'));
        }

        return redirect()->route('Industry.deliveries');
    }

    public function deleteDeliveryItem($deliveryId, $itemId, Request $request): RedirectResponse
    {
        $delivery = Delivery::find($deliveryId);
        $item = DeliveryItem::find($itemId);

        if ($item) {
            Gate::authorize('seat-industry.same-user', $delivery->user_id);

            if ($item->completed) {
                Gate::authorize('Industry.admin');
            }

            $item->delete();

            $request->session()->flash('success', trans('seat-industry::ai-deliveries.delivery_item_removal_success'));
        } else {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_delivery_item_not_found'));
        }

        $delivery->quantity = $delivery->totalQuantity();
        $delivery->save();

        return redirect()->back();
    }
}
