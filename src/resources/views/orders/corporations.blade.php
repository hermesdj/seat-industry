@extends('seat-industry::orders.layout.main', ['viewname' => 'corporationOrders'])

@section('orders_content')
    <div class="card">
        <div class="card-body p-2">
            <h5 class="card-header d-flex flex-row align-items-baseline">
                {{trans('seat-industry::ai-orders.list.titles.corporation')}}
                @can("seat-industry.create_orders")
                    <a href="{{ route("seat-industry.createOrder") }}"
                       class="btn btn-primary ml-auto">{{trans('seat-industry::ai-orders.create_order_title')}}</a>
                @endcan
            </h5>
            <div class="card-text pt-3">
                @include("seat-industry::orders.partials.orderTable",["orders"=>$orders])
            </div>
        </div>
    </div>
@endsection
