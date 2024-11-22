@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-deliveries.prepare.title'))
@section('page_header', trans('seat-industry::ai-deliveries.prepare.title'))

@section('full')
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-10">
            <div class="card border-top border-bottom border-3" style="border-color: #f37a27 !important;">
                <h5 class="lead fw-bold mb-1 card-header d-flex flex-row align-items-center px-1"
                    style="color: #f37a27;">
                    {{trans('seat-industry::ai-deliveries.prepare.title')}}
                </h5>
                <form action="{{ route("seat-industry.addDelivery", ['id' => $order->id]) }}" method="POST">
                    @csrf
                    <div class="card-body p-2">
                        <p class="card-text">
                            {{trans('seat-industry::ai-deliveries.prepare.description')}}
                        </p>
                        @include('seat-industry::partials.prepareDeliveryItemTable', ['items' => $items])
                        <div class="row text-right">
                            <div class="col px-4">
                                <button
                                        type="submit"
                                        class="btn btn-primary btn-lg"
                                >
                                    <i class="fas fa-truck"></i>&nbsp;
                                    {{trans('seat-industry::ai-deliveries.create_delivery_btn')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection