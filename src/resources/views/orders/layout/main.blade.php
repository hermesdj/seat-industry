@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-orders.order_marketplace_title'))
@section('page_header', trans('seat-industry::ai-orders.order_marketplace_title'))

@section('full')
    @include('seat-industry::partials.statistics', ['statistics' => $statistics])
    @include('seat-industry::orders.includes.mainMenu')
    @yield('orders_content')
@stop

@push("javascript")
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('.order-data-table').DataTable({
                stateSave: true,
                pageLength: 50
            });
        });
    </script>
@endpush
