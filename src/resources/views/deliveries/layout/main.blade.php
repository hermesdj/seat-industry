@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-deliveries.your_deliveries_title'))
@section('page_header', trans('seat-industry::ai-deliveries.your_deliveries_title'))

@section('full')
    @include('seat-industry::deliveries.includes.mainMenu')
    @yield('deliveries_content')
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