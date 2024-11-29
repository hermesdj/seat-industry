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
            <h5>{{trans('seat-industry::ai-orders.items.title.accepted')}}</h5>
            @include('seat-industry::orders.partials.orderItemTable', ['items' => $order->allowedItems])
        </div>
        @if($order->rejectedItems->isNotEmpty())
            <div class="mx-n5 px-5 py-4">
                <h5>{{trans('seat-industry::ai-orders.items.title.rejected')}}</h5>
                @include('seat-industry::orders.partials.orderItemTable', ['items' => $order->rejectedItems])
            </div>
        @endif
    </div>
@stop