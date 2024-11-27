@extends('seat-industry::orders.layout.view', ['viewname' => 'buildPlan'])

@section('order_content')
    <div class="alert alert-warning m-4" role="alert">
        <h4 class="alert-heading"><i class="fas fa-drafting-compass"></i>{{trans('seat-industry::industry.buildPlan.in_construction.title')}}
        </h4>
        <p>{{trans('seat-industry::industry.buildPlan.in_construction.desc')}}</p>
    </div>
@stop
