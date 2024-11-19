<?php

namespace HermesDj\Seat\Industry\Http\Controllers;

use Illuminate\Http\Request;
use HermesDj\Seat\Industry\IndustrySettings;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\Web\Http\Controllers\Controller;

class IndustrySettingsController extends Controller
{
    public function settings()
    {
        $stations = UniverseStation::all();
        $structures = UniverseStructure::all();

        $defaultOrderLocation = IndustrySettings::$DEFAULT_ORDER_LOCATION->get(60003760);
        $mpp = IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5);
        $orderCreationPingRoles = implode(" ", IndustrySettings::$ORDER_CREATION_PING_ROLES->get([]));
        $allowPriceBelowAutomatic = IndustrySettings::$ALLOW_PRICES_BELOW_AUTOMATIC->get(false);


        $default_price_provider = IndustrySettings::$DEFAULT_PRICE_PROVIDER->get();
        //dd($default_price_provider);

        $removeExpiredDeliveries = IndustrySettings::$REMOVE_EXPIRED_DELIVERIES->get(false);

        $allowedPriceProviders = IndustrySettings::$ALLOWED_PRICE_PROVIDERS->get([$default_price_provider]);

        return view(
            "seat-industry::settings",
            compact(
                "removeExpiredDeliveries",
                "default_price_provider",
                "mpp",
                "orderCreationPingRoles",
                "allowPriceBelowAutomatic",
                "stations",
                "structures",
                "defaultOrderLocation",
                "allowedPriceProviders"
            )
        );
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            "minimumprofitpercentage" => "required|numeric",
            "pingRolesOrderCreation" => "string|nullable",
            "allowPriceBelowAutomatic" => "nullable|in:on",
            "defaultLocation" => "required|integer",
            "defaultPriceProvider" => "required|integer",
            "removeExpiredDeliveries" => "nullable|in:on",
            "priceProviderWhitelist.*" => "integer"
        ]);

        $roles = [];
        if ($request->pingRolesOrderCreation) {
            //parse roles
            $roles = preg_replace('~\R~u', "\n", $request->pingRolesOrderCreation);
            $matches = [];
            preg_match_all("/\d+/m", $roles, $matches);
            $roles = $matches[0];
        }

        IndustrySettings::$DEFAULT_PRICE_PROVIDER->set((int)$request->defaultPriceProvider);

        IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->set(floatval($request->minimumprofitpercentage));
        IndustrySettings::$ORDER_CREATION_PING_ROLES->set($roles);
        IndustrySettings::$ALLOW_PRICES_BELOW_AUTOMATIC->set(boolval($request->allowPriceBelowAutomatic));
        IndustrySettings::$DEFAULT_ORDER_LOCATION->set($request->defaultLocation);
        IndustrySettings::$REMOVE_EXPIRED_DELIVERIES->set(boolval($request->removeExpiredDeliveries));
        IndustrySettings::$ALLOWED_PRICE_PROVIDERS->set($request->priceProviderWhitelist);

        $request->session()->flash("success", trans('seat-industry::ai-settings.update_settings_success'));
        return redirect()->route("Industry.settings");
    }
}