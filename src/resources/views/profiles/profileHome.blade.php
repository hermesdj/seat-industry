@extends('seat-industry::profiles.layouts.home', ['viewname' => 'profiles'])

@section('profile_content')
    @if(isset($profile))
        {{$profile}}
    @else
        Select a Profile to display
    @endif
@endsection