@extends('web::layouts.grids.4-8')
@section('title', trans('seat-industry::profiles.home.title'))
@section('page_header', trans('seat-industry::profiles.home.title'))

@include('seat-industry::modals.profile.createProfile')

@section('left')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title float-left">
                {{trans('seat-industry::profiles.list.title')}}
            </h5>
            <button
                    class="float-right btn btn-primary"
                    type="button"
                    data-toggle="modal"
                    data-target="#modalCreateProfile"
            >
                {{trans('seat-industry::profiles.btns.create')}}
            </button>
        </div>
        @include('seat-industry::profiles.includes.nav-profiles', ['listTitle' => trans('seat-industry::profiles.list.titles.public_profiles'), 'profileList' => $profiles->public, 'activeProfile' => $profile])
        @include('seat-industry::profiles.includes.nav-profiles', ['listTitle' => trans('seat-industry::profiles.list.titles.alliance_profiles'), 'profileList' => $profiles->alliance, 'activeProfile' => $profile])
        @include('seat-industry::profiles.includes.nav-profiles', ['listTitle' => trans('seat-industry::profiles.list.titles.corporation_profiles'), 'profileList' => $profiles->corporation, 'activeProfile' => $profile])
        @include('seat-industry::profiles.includes.nav-profiles', ['listTitle' => trans('seat-industry::profiles.list.titles.personal_profiles'), 'profileList' => $profiles->personal, 'activeProfile' => $profile])
    </div>
@endsection
@section('right')
    @yield('profile_content')
@endsection