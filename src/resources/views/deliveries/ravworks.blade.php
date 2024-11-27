@extends('seat-industry::deliveries.layout.view', ['viewname' => 'ravworks'])

@section('delivery_content')
    <div class="row m-3">
        <div class="col-9">
            {!! trans('seat-industry::industry.ravworks.description') !!}
        </div>
        <div class="col-3 text-right">
            @can('seat-industry.update_stocks')
                <form action="{{ route("seat-industry.updateStocks", ['order' => $delivery->order_id]) }}"
                      method="POST"
                      class="mx-1">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-sync"></i>&nbsp;{{trans('seat-industry::industry.stocks.updateStocksBtn')}}
                    </button>
                </form>
            @endcan
        </div>
    </div>
    <div class="row" style="height: 100%">
        <div class="col-12">
            @include('seat-industry::partials.ravworks.summary', ['buildPlan' => $buildPlan, 'code' => $delivery->order->order_id])
        </div>
        <div class="col m-3">
            @include('seat-industry::partials.ravworks.produce', ['buildPlan' => $buildPlan, 'code' => $delivery->order->order_id])
        </div>
        <div class="col m-3" style="height: 100%">
            @include('seat-industry::partials.ravworks.stocks', ['buildPlan' => $buildPlan, 'code' => $delivery->order->order_id])
        </div>
    </div>
@stop
