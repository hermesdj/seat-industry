@include('seat-industry::modals.orders.edit-prices-modal', ['order' => $order, 'mpp' => Seat\HermesDj\Industry\IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5)])
@include('seat-industry::modals.orders.edit-time-modal', ['order' => $order])

<div class="d-flex flex-row mb-3">
    @can("seat-industry.same-user",$order->user_id)
        @if($order->confirmed)
            @if($order->deliveries->isEmpty())
                <form action="{{ route("seat-industry.deleteOrder", ['order' => $order->id]) }}" method="POST"
                      class="mx-1">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger">
                        <i class="fas fa-times "></i>&nbsp;
                        {{trans('seat-industry::ai-orders.btns.deleteOrder')}}
                    </button>
                </form>
            @endif
            @if(!$order->deliveries->isEmpty() && (!$order->hasPendingDeliveries() || $order->completed))
                <form action="{{ route("seat-industry.completeOrder", ['order' => $order->id]) }}" method="POST"
                      class="mx-1">
                    @csrf
                    <button type="submit"
                            class="btn btn-success">
                        <i class="fas fa-check-circle"></i>&nbsp;
                        {{trans('seat-industry::ai-orders.btns.completeOrder')}}
                    </button>
                </form>
            @endif
        @else
            <form action="{{ route("seat-industry.confirmOrder", ['order' => $order->id]) }}"
                  method="POST"
                  class="mx-1">
                @csrf
                <button type="submit"
                        class="btn btn-success">
                    <i class="fa fa-check "></i>&nbsp;
                    {{trans('seat-industry::ai-orders.confirm_order_btn')}}
                </button>
            </form>
            @if($order->deliveries->isEmpty() || !$order->hasPendingDeliveries() || $order->completed || auth()->user()->can("seat-industry.admin"))
                <form action="{{ route("seat-industry.deleteOrder", ['order' => $order->id]) }}" method="POST"
                      class="mx-1">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger">
                        <i class="fas fa-times "></i>&nbsp;
                        {{trans('seat-industry::ai-orders.close_order_btn')}}
                    </button>
                </form>
            @endif
        @endif
        @if(!$order->completed && !$order->is_repeating && !$order->hasPendingDeliveries())
            <button
                    type="button"
                    class="btn btn-secondary mx-1"
                    data-toggle="modal"
                    data-target="#modalEditOrderPrices"
            >
                <i class="fas fa-dollar-sign"></i>&nbsp;
                {{trans('seat-industry::ai-orders.update_price_btn')}}
            </button>
        @endif
        @if(!$order->is_repeating && !$order->completed)
            <button
                    type="button"
                    class="btn btn-secondary mx-1"
                    data-toggle="modal"
                    data-target="#modalEditOrderTime"
            >
                <i class="fas fa-clock "></i>&nbsp;
                {{trans('seat-industry::ai-orders.extend_time_btn')}}
            </button>
        @endif
    @endcan
    @can('seat-industry.corp_delivery')
        <form action="{{ route("seat-industry.toggleReserveCorp", ['order' => $order->id]) }}"
              method="POST"
              class="mx-1">
            @csrf
            @if($order->corporation != null)
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times "></i>&nbsp;{{trans('seat-industry::ai-orders.btns.unReserveCorp')}}
                </button>
            @else
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>&nbsp;{{trans('seat-industry::ai-orders.btns.reserveCorp')}}
                </button>
            @endif
        </form>
        @if($order->assignedQuantity() < $order->totalQuantity() && $order->isCorpAllowed(auth()->user()))
            <a
                    href="{{ route("seat-industry.prepareDelivery", ['order' => $order->id]) }}"
                    class="btn btn-primary mx-1 ml-auto">
                <i class="fas fa-truck"></i>&nbsp;
                {{trans('seat-industry::ai-deliveries.order_create_delivery_btn')}}
            </a>
        @endif
    @endcan
    @if($order->confirmed)
        @if($order->assignedQuantity() < $order->totalQuantity() && !$order->corporation)
            <form action="{{ route("seat-industry.prepareDelivery", ['order' => $order->id]) }}"
                  method="POST"
                  class="mx-1 ml-auto"
            >
                @csrf
                <input type="hidden" name="fill" value="0"/>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-truck"></i>&nbsp;
                    &nbsp;{{trans('seat-industry::ai-deliveries.order_create_delivery_btn')}}
                </button>
            </form>
        @endif
    @endif
</div>
