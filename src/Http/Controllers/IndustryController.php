<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Seat\Web\Http\Controllers\Controller;

class IndustryController extends Controller
{
    public function about(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('seat-industry::about');
    }
}
