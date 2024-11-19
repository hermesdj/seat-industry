<?php

namespace HermesDj\Seat\Industry\Api;

use HermesDj\Seat\Industry\IndustrySettings;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;

class IndustryApi
{
    public static function create_orders($data): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $location_id = $data["location"] ?? 60003760;

        // TODO toMultibuy ??
        $multibuy = $data["items"]->toMultibuy();

        $stations = UniverseStation::all();
        $structures = UniverseStructure::all();
        $mpp = IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5);

        $default_price_provider = IndustrySettings::$DEFAULT_PRICE_PROVIDER->get();

        return view("seat-industry::createOrder", compact("stations", "default_price_provider", "structures", "mpp", "location_id", "multibuy"));
    }
}