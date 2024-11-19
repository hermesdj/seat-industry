@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-orders.order_marketplace_title'))
@section('page_header', trans('seat-industry::ai-orders.order_marketplace_title'))


@section('full')
    @include('seat-industry::partials.statistics', ['statistics' => $statistics])
    <div class="card">
        <div class="card-body">
            <h5 class="card-header d-flex flex-row align-items-baseline">
                {{trans('seat-industry::ai-orders.open_orders_title')}}
                @can("Industry.create_orders")
                    <a href="{{ route("Industry.createOrder") }}"
                       class="btn btn-primary ml-auto">{{trans('seat-industry::ai-orders.create_order_title')}}</a>
                @endcan
            </h5>
            <div class="card-text pt-3">
                @include("seat-industry::partials.orderTable",["orders"=>$orders])
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-header d-flex flex-row align-items-baseline">
                {{trans('seat-industry::ai-orders.your_orders_title')}}

                @if($personalOrders->where("completed",true)->isNotEmpty())
                    <form action="{{ route("Industry.deleteCompletedOrders") }}" method="POST" class="ml-auto">
                        @csrf
                        <button class="btn btn-danger">{{trans('seat-industry::ai-orders.close_all_completed_orders_btn')}}</button>
                    </form>
                @endif
            </h5>
            <div class="card-text pt-3">
                @include("seat-industry::partials.orderTable",["orders"=>$personalOrders])
            </div>
        </div>
    </div>
@stop

@push("javascript")
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('.data-table').DataTable({
                stateSave: true,
            });
        });
    </script>
@endpush