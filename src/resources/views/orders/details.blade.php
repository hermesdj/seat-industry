@extends('seat-industry::orders.layout.view', ['viewname' => 'details'])

@section('order_content')
    <div class="px-2">
        @can('seat-industry.admin')
            <form action="{{ route("seat-industry.updateOrderItemState", ['order' => $order->id]) }}" method="POST"
                  class="mx-1 mt-2">
                @csrf
                <button type="submit"
                        class="btn btn-warning">
                    <i class="fas fa-cog"></i>&nbsp;
                    {{trans('seat-industry::ai-orders.btns.updateOrderItemStates')}}
                </button>
            </form>
        @endcan
        <div class="mx-n5 px-5 py-4">
            <div class="row">
                <div class="col">
                    <h5 class="float-left">{{trans('seat-industry::ai-orders.items.title.accepted')}}</h5>
                </div>
            </div>
            @include('seat-industry::orders.partials.orderItemTable', ['items' => $order->allowedItems])
        </div>
        @if($order->rejectedItems->isNotEmpty())
            <div class="mx-n5 px-5 py-4">
                <div class="row">
                    <div class="col">
                        <h5 class="float-left">{{trans('seat-industry::ai-orders.items.title.rejected')}}</h5>
                        @if($order->hasRejectedItemsNotDelivered())
                            <button
                                    type="button" class="btn btn-secondary btn-sm m-1 float-right"
                                    onclick="execBuyAll(this, {{json_encode($order->formatRejectedToBuyAll())}})"
                                    data-container="body"
                                    data-toggle="popover"
                                    data-placement="top"
                                    data-content="{{trans('seat-industry::ai-common.messages.copy_response')}}"
                            >
                                <i class="fas fa-cart"></i>
                                {{trans("seat-industry::ai-common.btns.buy_all")}}
                            </button>
                        @endif
                    </div>
                </div>
                @include('seat-industry::orders.partials.orderItemTable', ['items' => $order->rejectedItems])
            </div>
        @endif
    </div>
@stop

@push('javascript')
    <script>
        function execBuyAll(object, content) {
            navigator.clipboard.writeText(content);
            $(object).popover().click(function () {
                setTimeout(function () {
                    $(object).popover('hide');
                }, 1000);
            });
        }
    </script>
@endpush