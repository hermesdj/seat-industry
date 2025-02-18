<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Seat\HermesDj\Industry\Models\Profiles\IndustryProfile;
use Seat\Web\Http\Controllers\Controller;

class IndustryProfileController extends Controller
{
    public function profiles(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $profiles = IndustryProfile::loadAll();
        $profile = null;

        return view('seat-industry::profiles.profileHome', compact('profiles', 'profile'));
    }

    public function profile(IndustryProfile $profile): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $profiles = IndustryProfile::loadAll();

        return view('seat-industry::profiles.profileHome', compact('profiles', 'profile'));
    }

    public function createProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:64',
            'scope' => 'required|string',
        ]);

        $profile = new IndustryProfile;
        $profile->name = $data['name'];
        $profile->scope = $data['scope'];
        $profile->user_id = auth()->user()->id;

        switch ($data['scope']) {
            case 'corporation':
                $profile->corp_id = auth()->user()->main_character->affiliation->corporation_id;
                break;
            case 'alliance':
                $profile->alliance_id = auth()->user()->main_character->affiliation->alliance_id;
                break;
        }

        $profile->save();

        $request->session()->flash('success', trans('seat-industry::profiles.messages.create_profile_success'));

        return redirect()->route('seat-industry.profile', ['profile' => $profile->id]);
    }

    public function updateProfile() {}

    public function deleteProfile() {}
}
