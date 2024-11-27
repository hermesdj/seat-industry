@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-deliveries.your_deliveries_title'))
@section('page_header', trans('seat-industry::ai-deliveries.your_deliveries_title'))


@section('full')
    <div class="card">
        <div class="card-body">
            <h5 class="card-header d-flex flex-row align-items-baseline">
                {{trans('seat-industry::ai-deliveries.your_deliveries_title')}}
            </h5>
            <div class="card-text pt-3">
                @include("seat-industry::deliveries.partials.deliveryTable",["deliveries"=>$deliveries,"showOrder"=>true])
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
                pageLength: 50
            });
        });
    </script>
@endpush