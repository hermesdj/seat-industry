@include('seat-industry::modals.orders.edit-prices-modal', ['order' => $order, 'mpp' => Seat\HermesDj\Industry\IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5)])
@include('seat-industry::modals.orders.edit-time-modal', ['order' => $order])
@include('seat-industry::modals.orders.edit-details-modal', ['order' => $order])
@include('seat-industry::modals.orders.confirm-complete-order', ['order' => $order])

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
                @csrf
                <button
                        type="button"
                        class="btn btn-success mx-1"
                        data-toggle="modal"
                        data-target="#modalConfirmCompleteOrder"
                >
                    <i class="fas fa-check-circle"></i>&nbsp;
                    {{trans('seat-industry::ai-orders.btns.completeOrder')}}
                </button>
            @endif
        @else
            <form action="{{ route("seat-industry.confirmOrder", ['order' => $order->id]) }}"
                  method="POST"
                  class="mx-1">
                @csrf
                <button type="submit"
                        class="btn btn-success">
                    <i class="fa fa-check "></i>&nbsp;
                    {{trans('seat-industry::ai-orders.btns.confirmOrder')}}
                </button>
            </form>
            @if($order->deliveries->isEmpty() || !$order->hasPendingDeliveries() || $order->completed || auth()->user()->can("seat-industry.admin"))
                <form action="{{ route("seat-industry.deleteOrder", ['order' => $order->id]) }}" method="POST"
                      class="mx-1">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger">
                        <i class="fas fa-times "></i>&nbsp;
                        {{trans('seat-industry::ai-orders.btns.closeOrder')}}
                    </button>
                </form>
            @endif
        @endif
        <button
                type="button"
                class="btn btn-secondary mx-1"
                data-toggle="modal"
                data-target="#modalEditDetails"
        >
            <i class="fas fa-pen"></i>&nbsp;
            {{trans('seat-industry::ai-orders.modals.editDetails.btn')}}
        </button>
        @if(!$order->completed && !$order->is_repeating && !$order->hasPendingDeliveries())
            <button
                    type="button"
                    class="btn btn-secondary mx-1"
                    data-toggle="modal"
                    data-target="#modalEditOrderPrices"
            >
                <i class="fas fa-dollar-sign"></i>&nbsp;
                {{trans('seat-industry::ai-orders.modals.editPrices.btn')}}
            </button>
        @endif
        @if(!$order->is_repeating && !$order->completed)
            <button
                    type="button"
                    class="btn btn-secondary mx-1"
                    data-toggle="modal"
                    data-target="#modalEditOrderTime"
            >
                <i class="fas fa-clock"></i>&nbsp;
                {{trans('seat-industry::ai-orders.modals.editTime.btn')}}
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
        @can('seat-industry.create_deliveries')
            @if($order->assignedQuantity() < $order->totalQuantity() && $order->isCorpAllowed(auth()->user()))
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
        @endcan
    @endcan
    @if($order->confirmed)
        @can('seat-industry.create_deliveries')
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
        @endcan
    @endif
</div>
