<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException;
use RecursiveTree\Seat\PricesCore\Facades\PriceProviderSystem;
use RecursiveTree\Seat\TreeLib\Helpers\SeatInventoryPluginHelper;
use RecursiveTree\Seat\TreeLib\Parser\Parser;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\HermesDj\Industry\Helpers\OrderHelper;
use Seat\HermesDj\Industry\IndustrySettings;
use Seat\HermesDj\Industry\Item\PriceableEveItem;
use Seat\HermesDj\Industry\Jobs\SendOrderNotification;
use Seat\HermesDj\Industry\Jobs\UpdateRepeatingOrders;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\HermesDj\Industry\Models\Orders\OrderItem;
use Seat\HermesDj\Industry\Models\Statistics\OrderStatistic;
use Seat\Web\Http\Controllers\Controller;

class IndustryOrderController extends Controller
{
    private const MaxOrderIdLength = 6;

    public function orders(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $orders = Order::with('deliveries')
            ->where('confirmed', true)
            ->where('completed', false)
            ->where('produce_until', '>', DB::raw('NOW()'))
            ->where('is_repeating', false)
            ->get()
            ->filter(function ($order) {
                return $order->assignedQuantity() < $order->totalQuantity();
            })
            ->filter(function ($order) {
                return $order->corp_id == null || $order->corp_id == auth()->user()->main_character->affiliation->corporation_id || $order->user_id == auth()->user()->id;
            });

        $personalOrders = Order::where('user_id', auth()->user()->id)->get();

        $statistics = OrderStatistic::generateAll();

        return view('seat-industry::orders', compact('orders', 'personalOrders', 'statistics'));
    }

    public function createOrder(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        //ALSO UPDATE API
        $stations = UniverseStation::all();
        //ALSO UPDATE API
        $structures = UniverseStructure::all();

        //ALSO UPDATE API
        $mpp = IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5);
        //ALSO UPDATE API
        $location_id = IndustrySettings::$DEFAULT_ORDER_LOCATION->get(60003760);
        //ALSO UPDATE API
        $default_price_provider = IndustrySettings::$DEFAULT_PRICE_PROVIDER->get();
        //ALSO UPDATE API

        $defaultPriority = IndustrySettings::$DEFAULT_PRIORITY->get(2);

        //ALSO UPDATE API
        return view('seat-industry::createOrder',
            compact(
                'stations',
                'structures',
                'mpp',
                'location_id',
                'default_price_provider',
                'defaultPriority'
            )
        );
    }

    protected function parsePriceProviderItems($item_array, $price_modifier = 1): array
    {
        $items = [];

        foreach ($item_array as $item) {
            $item->price = intval($item->price * $price_modifier * 100);

            $typeID = $item->typeModel->typeID;

            if (! array_key_exists($typeID, $items)) {
                $items[$typeID] = (object) [
                    'typeID' => $typeID,
                    'price' => $item->price,
                    'quantity' => $item->amount,
                    'unitPrice' => $item->price / $item->amount,
                ];
            } else {
                $items[$typeID]->quantity += $item->amount;
            }
        }

        return $items;
    }

    protected function computeOrderTotal($items): int
    {
        $total_price = 0;

        foreach ($items as $item) {
            $total_price += $item->price;
        }

        return $total_price;
    }

    public function submitOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'items' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'profit' => 'required|numeric',
            'days' => 'required|integer|min:1',
            'location' => 'required|integer',
            'addToSeatInventory' => 'nullable|in:on',
            'priority' => 'integer',
            'priceprovider' => 'nullable|integer',
            'repetition' => 'nullable|integer',
            'reference' => 'nullable|string|max:32',
            'deliverTo' => 'integer',
        ]);

        if (! $request->priority) {
            $request->priority = 2;
        }

        if (auth()->user()->can('seat-industry.change_price_provider')) {
            $priceProvider = $request->priceprovider;
        } else {
            $priceProvider = IndustrySettings::$DEFAULT_PRICE_PROVIDER->get(null);
        }

        if ($priceProvider == null) {
            return redirect()->back()->with('error', trans('seat-industry::ai-common.error_no_price_provider'));
        }

        $mpp = IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5);
        if ($request->profit < $mpp) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_minimal_profit_too_low', ['mpp' => $mpp]));

            return redirect()->route('seat-industry.createOrder');
        }

        if (! (UniverseStructure::where('structure_id', $request->location)->exists() || UniverseStation::where('station_id', $request->location)->exists())) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_structure_not_found'));

            return redirect()->route('seat-industry.orders');
        }

        //parse items
        $parser_result = Parser::parseItems($request->items, PriceableEveItem::class);

        //check item count, don't request prices without any items
        if ($parser_result == null || $parser_result->items->isEmpty()) {
            $request->session()->flash('warning', trans('seat-industry::ai-common.error_order_is_empty'));

            return redirect()->route('seat-industry.orders');
        }

        try {
            PriceProviderSystem::getPrices($priceProvider, $parser_result->items);
        } catch (PriceProviderException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $now = now();
        $produce_until = now()->addDays($request->days);
        $price_modifier = (1 + (floatval($request->profit) / 100.0));
        // TODO Move to its own function $prohibitManualPricesBelowValue = !IndustrySettings::$ALLOW_PRICES_BELOW_AUTOMATIC->get(false);
        $addToSeatInventory = $request->addToSeatInventory !== null;

        if (! SeatInventoryPluginHelper::pluginIsAvailable()) {
            $addToSeatInventory = false;
        }

        $items = $this->parsePriceProviderItems($parser_result->items, $price_modifier);

        // Create order
        $total_price = $this->computeOrderTotal($items);

        $order = new Order;
        $order->order_id = OrderHelper::generateRandomString(self::MaxOrderIdLength);

        if ($request->reference != null) {
            $order->reference = $request->reference;
        } else {
            if ($parser_result->shipName != null) {
                $order->reference = $parser_result->shipName;
            } else {
                $order->reference = $order->order_id;
            }
        }

        $order->quantity = $request->quantity;
        $order->user_id = auth()->user()->id;
        $order->price = $total_price * $order->quantity;
        $order->location_id = $request->location;
        $order->created_at = $now;
        $order->deliver_to = $request->deliverTo;
        $order->produce_until = $produce_until;
        $order->add_seat_inventory = $addToSeatInventory;
        $order->profit = floatval($request->profit);
        $order->priority = $request->priority;
        $order->priceProvider = $priceProvider;
        $order->confirmed = false;

        $repetition = intval($request->repetition);
        if ($repetition > 0) {
            Gate::authorize('seat-industry.create_repeating_orders');
            $order->is_repeating = true;
            $order->repeat_interval = $repetition;
            $order->repeat_date = now();
        }

        $order->save();

        foreach ($items as $item) {
            $model = new OrderItem;
            $model->order_id = $order->id;
            $model->type_id = $item->typeID;
            $model->quantity = $item->quantity * $order->quantity;
            $model->unit_price = $item->unitPrice;
            $model->save();
        }

        // update repeating orders
        UpdateRepeatingOrders::dispatch();

        $request->session()->flash('success', trans('seat-industry::ai-orders.create_order_success'));

        return redirect()->route('seat-industry.orderDetails', ['id' => $order->id]);
    }

    public function confirmOrder($orderId, Request $request): RedirectResponse
    {
        $order = Order::find($orderId);

        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->route('seat-industry.orders');
        }

        $order->confirmed = true;
        $order->save();

        //send notification that orders have been put up. We don't do it in an observer so it only gets triggered once
        SendOrderNotification::dispatch($order);

        return redirect()->back();
    }

    public function extendOrderTime($orderId, Request $request): RedirectResponse
    {
        $data = (object) $request->validate([
            'time' => 'required|integer|min:7',
        ]);

        $order = Order::find($orderId);

        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->back();
        }

        Gate::authorize('seat-industry.same-user', $order->user_id);

        $order->produce_until = carbon($order->produce_until)->addDays($data->time);
        $order->save();

        $request->session()->flash('success', trans('seat-industry::ai-orders.update_time_success'));

        return redirect()->back();
    }

    public function updateOrderPrice($orderId, Request $request)
    {
        $data = (object) $request->validate([
            'profit' => 'nullable|numeric',
            'priceprovider' => 'nullable|integer',
        ]);

        $order = Order::find($orderId);

        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->back();
        }

        if ($order->hasPendingDeliveries()) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_has_uncomplete_deliveries'));

            return redirect()->back();
        }

        if (! is_null($data->profit) && $order->profit !== $data->profit) {
            $order->profit = $data->profit;
        }

        if (isset($data->priceprovider) && ! is_null($data->priceprovider) && $order->priceProvider !== $data->priceprovider) {
            $order->priceProvider = $data->priceprovider;
        }

        $order->save();

        Gate::authorize('seat-industry.same-user', $order->user_id);

        $profit_multiplier = 1 + ($order->profit / 100.0);

        $item_list = $order->items->map(function ($item) {
            return $item->toEveItem();
        });

        //null is only after update, so don't use the setting
        $priceProvider = $order->priceProvider;
        if ($priceProvider === null) {
            return redirect()->back()->with('error', trans('seat-industry::ai-common.error_obsolete_order'));
        }

        try {
            PriceProviderSystem::getPrices($priceProvider, $item_list);
        } catch (PriceProviderException $e) {
            return redirect()->back()->with('error', trans('seat-industry::ai-common.error_price_provider_get_prices', ['message' => $e->getMessage()]));
        }

        $items = $this->parsePriceProviderItems($item_list, $profit_multiplier);

        $order->price = $this->computeOrderTotal($items);
        $order->save();

        foreach ($items as $item) {
            OrderItem::where('order_id', $order->id)
                ->where('type_id', $item->typeID)
                ->update([
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unitPrice]
                );
        }

        $request->session()->flash('success', trans('seat-industry::ai-orders.update_price_success'));

        return redirect()->back();
    }

    public function orderDetails($id, Request $request): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $order = Order::with('deliveries')->find($id);

        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->route('seat-industry.orders');
        }

        $mpp = IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5);

        return view('seat-industry::orderDetails', compact('order', 'mpp'));
    }

    public function deleteOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'order' => 'required|integer',
        ]);

        $order = Order::find($request->order);
        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->route('seat-industry.orders');
        }

        Gate::authorize('seat-industry.same-user', $order->user_id);

        if ($order->hasPendingDeliveries() && ! auth()->user()->can('seat-industry.admin')) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_deleted_in_progress_order'));

            return redirect()->route('seat-industry.orders');
        }

        $order->delete();

        $request->session()->flash('success', trans('seat-industry::ai-orders.close_order_success'));

        return redirect()->route('seat-industry.orders');
    }

    public function deleteCompletedOrders(): RedirectResponse
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('completed', true)->where('is_repeating', false)->get();
        foreach ($orders as $order) {
            $order->delete();
        }

        return redirect()->back();
    }

    public function toggleReserveCorp($orderId, Request $request): RedirectResponse
    {
        $order = Order::find($orderId);

        if (! $order) {
            $request->session()->flash('error', trans('seat-industry::ai-common.error_order_not_found'));

            return redirect()->route('seat-industry.orders');
        }

        if ($order->corp_id) {
            $order->corp_id = null;
        } else {
            $order->corp_id = auth()->user()->main_character->affiliation->corporation_id;
        }

        $order->save();

        return redirect()->back();
    }
}
