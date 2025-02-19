@extends('seat-industry::deliveries.layout.main', ['viewname' => 'allDeliveries'])

@section('title', trans('seat-industry::ai-deliveries.all_deliveries_title'))
@section('page_header', trans('seat-industry::ai-deliveries.all_deliveries_title'))


@section('deliveries_content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-header d-flex flex-row align-items-baseline">
                {{trans('seat-industry::ai-deliveries.all_deliveries_title')}}
            </h5>
            <div class="card-text pt-3">
                @include("seat-industry::deliveries.partials.deliveryTable",["deliveries.blade.php"=>$deliveries, "showOrder"=>true, "showProducer" => true])
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