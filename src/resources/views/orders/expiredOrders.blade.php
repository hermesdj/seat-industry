@extends('seat-industry::orders.layout.main', ['viewname' => 'available'])

@section('orders_content')
    <div class="card">
        <div class="card-body p-2">
            <div class="card-text pt-3">
                @include("seat-industry::orders.partials.orderTable",["orders"=>$orders])
            </div>
        </div>
    </div>
@endsection
