@extends('seat-industry::deliveries.layout.view', ['viewname' => 'details'])
@section('delivery_content')
    <div class="p-2">
        <div class="mx-n5 px-5">
            <h5>{{trans('seat-industry::ai-deliveries.items.title')}}</h5>
            @include('seat-industry::deliveries.partials.deliveryItemTable', ['items' => $delivery->deliveryItems])
        </div>
    </div>
@stop