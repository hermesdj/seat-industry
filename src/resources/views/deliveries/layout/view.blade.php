@extends('web::layouts.grids.8-4')

@section('title', trans('seat-industry::ai-deliveries.delivery_title', ['code' => $delivery->delivery_code]))
@section('page_header', trans('seat-industry::ai-deliveries.delivery_title', ['code' => $delivery->delivery_code]))

@section('left')
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-10">
            @include("seat-industry::deliveries.includes.delivery-btns")
            <div class="card border-top border-bottom border-3" style="border-color: darkgoldenrod !important;">
                <div class="card-body p-2 mb-2">
                    @include("seat-industry::deliveries.includes.summary")
                </div>
                <div>
                    @include('seat-industry::deliveries.includes.menu', ['viewname' => $viewname])
                </div>
                @yield('delivery_content')
            </div>
        </div>
    </div>
@stop
@section('right')
    <div class="card">
        <div class="card-body">
            <label for="items">
                <i
                        class="fas fa-question-circle text-info" data-trigger="hover" data-toggle="popover"
                        data-placement="bottom"
                        data-html="true"
                        title="{{trans('seat-industry::ai-deliveries.instructions.title')}}"
                        data-content="{{trans('seat-industry::ai-deliveries.instructions.text')}}"
                ></i>
                {{ trans('seat-industry::ai-deliveries.contract.label') }}&nbsp;
            </label>
            <p>{{ trans('seat-industry::ai-deliveries.contract.introduction') }}</p>
            @include('seat-industry::deliveries.partials.contract-summary')
            <div>
                <span><b>{{ trans('seat-industry::ai-deliveries.contract.tip_title') }}</b></span>
                <p>{{ trans('seat-industry::ai-deliveries.contract.tip') }}</p>
            </div>
        </div>
    </div>
@endsection
@push("javascript")
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('.data-table').DataTable({
                stateSave: true
            });
            $('.delivery-item-table').DataTable({
                stateSave: true,
                pageLength: 50
            });
        });
    </script>
@endpush