@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-about.about_title'))
@section('page_header', trans('seat-industry::ai-about.about_title'))


@section('full')
    @include("treelib::giveaway")

    <div class="card">
        <div class="card-body">
            <h5 class="card-header">
                {{trans('seat-industry::ai-about.about_title')}}
            </h5>
            <div class="card-text my-3 mx-3">
                <h6>
                    {{trans('seat-industry::ai-about.what_is_seat_alliance_industry_header')}}
                </h6>
                <p>
                    {!! trans('seat-industry::ai-about.what_is_seat_alliance_industry_desc') !!}
                </p>

                <h6>{{trans('seat-industry::ai-about.development_header')}}</h6>
                <p>
                    {!! trans('seat-industry::ai-about.development_desc') !!}
                </p>
                <p>
                    {!! trans('seat-industry::ai-about.development_contact') !!}
                </p>

                <h6>{{trans('seat-industry::ai-about.usage_header')}}</h6>
                <p>
                    {!! trans('seat-industry::ai-about.usage_desc') !!}
                </p>
            </div>
        </div>
    </div>
@stop