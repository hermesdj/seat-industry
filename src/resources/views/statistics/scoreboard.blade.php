@extends('seat-industry::statistics.layout.view')

@section('title', trans('seat-industry::stats.scoreboard.title'))
@section('page_header', trans('seat-industry::stats.scoreboard.title'))

@section('stats-content')
    @include('seat-industry::statistics.partials.scores.month-scores', compact('producersCountQuery', 'producersMeanTimeQuery', 'fastestProducerQuery'))
    @include('seat-industry::statistics.partials.scores.year-scores', compact('producersCountQuery', 'producersMeanTimeQuery', 'fastestProducerQuery'))
    @include('seat-industry::statistics.partials.scores.all-time-scores', compact('producersCountQuery', 'producersMeanTimeQuery', 'fastestProducerQuery'))
@stop
