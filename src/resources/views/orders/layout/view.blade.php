@extends('web::layouts.grids.8-4')
@section('title', trans('seat-industry::ai-orders.order_title', ['code' => $order->order_id, 'reference' => $order->reference]))
@section('page_header', trans('seat-industry::ai-orders.order_title', ['code' => $order->order_id, 'reference' => $order->reference]))

@section('left')
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-10">
            @include("seat-industry::orders.includes.order-btns")
            <div class="card border-top border-bottom border-3" style="border-color: darkgoldenrod !important;">
                <div class="card-body p-2 mb-2">
                    @include("seat-industry::orders.includes.summary")
                </div>
                <div>
                    @include('seat-industry::orders.includes.menu', ['viewname' => $viewname])
                </div>
                @yield('order_content')
            </div>
        </div>
    </div>
@stop
@section('right')
    <div class="card">
        <div class="card-body">
            <label for="items"> {{ trans('seat-industry::ai-orders.summary.title') }}</label>
            @include('seat-industry::orders.partials.order-summary', ['order' => $order])
        </div>
    </div>
@stop
@push("javascript")
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('.data-table').DataTable({
                stateSave: true,
                pageLength: 50
            });
            $('.order-item-table').DataTable({
                stateSave: true,
                pageLength: 50
            });
        });
    </script>
@endpush
