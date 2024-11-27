@extends('seat-industry::orders.layout.view', ['viewname' => 'deliveryDetails'])

@section('order_content')
    <div class="p-2">
        @include("seat-industry::deliveries.partials.deliveryTable", ["deliveries"=>$order->deliveries])
    </div>
@stop
