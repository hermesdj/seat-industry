<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Seat\Eveapi\Models\Universe\UniverseStation;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\HermesDj\Industry\IndustrySettings;
use Seat\Web\Http\Controllers\Controller;

class IndustrySettingsController extends Controller
{
    public function settings(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $stations = UniverseStation::all();
        $structures = UniverseStructure::all();

        $defaultOrderLocation = IndustrySettings::$DEFAULT_ORDER_LOCATION->get(60003760);
        $mpp = IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->get(2.5);
        $orderCreationPingRoles = implode(' ', IndustrySettings::$ORDER_CREATION_PING_ROLES->get([]));
        $allowPriceBelowAutomatic = IndustrySettings::$ALLOW_PRICES_BELOW_AUTOMATIC->get(false);

        $default_price_provider = IndustrySettings::$DEFAULT_PRICE_PROVIDER->get();
        //dd($default_price_provider);

        $removeExpiredDeliveries = IndustrySettings::$REMOVE_EXPIRED_DELIVERIES->get(false);

        $allowedPriceProviders = IndustrySettings::$ALLOWED_PRICE_PROVIDERS->get([$default_price_provider]);

        $metaTypeWhiteList = IndustrySettings::$ALLOWED_META_TYPES->get([]);

        return view(
            'seat-industry::settings',
            compact(
                'removeExpiredDeliveries',
                'default_price_provider',
                'mpp',
                'orderCreationPingRoles',
                'allowPriceBelowAutomatic',
                'stations',
                'structures',
                'defaultOrderLocation',
                'allowedPriceProviders',
                'metaTypeWhiteList'
            )
        );
    }

    public function saveSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'minimumprofitpercentage' => 'required|numeric',
            'pingRolesOrderCreation' => 'string|nullable',
            'allowPriceBelowAutomatic' => 'nullable|in:on',
            'defaultLocation' => 'required|integer',
            'defaultPriceProvider' => 'required|integer',
            'removeExpiredDeliveries' => 'nullable|in:on',
            'priceProviderWhitelist.*' => 'integer',
            'metaTypeWhiteList.*' => 'integer',
        ]);

        $roles = [];
        if ($request->pingRolesOrderCreation) {
            //parse roles
            $roles = preg_replace('~\R~u', "\n", $request->pingRolesOrderCreation);
            $matches = [];
            preg_match_all("/\d+/m", $roles, $matches);
            $roles = $matches[0];
        }

        IndustrySettings::$DEFAULT_PRICE_PROVIDER->set((int) $request->defaultPriceProvider);

        IndustrySettings::$MINIMUM_PROFIT_PERCENTAGE->set(floatval($request->minimumprofitpercentage));
        IndustrySettings::$ORDER_CREATION_PING_ROLES->set($roles);
        IndustrySettings::$ALLOW_PRICES_BELOW_AUTOMATIC->set(boolval($request->allowPriceBelowAutomatic));
        IndustrySettings::$DEFAULT_ORDER_LOCATION->set($request->defaultLocation);
        IndustrySettings::$REMOVE_EXPIRED_DELIVERIES->set(boolval($request->removeExpiredDeliveries));
        IndustrySettings::$ALLOWED_PRICE_PROVIDERS->set($request->priceProviderWhitelist);
        IndustrySettings::$ALLOWED_META_TYPES->set($request->metaTypeWhiteList);

        $request->session()->flash('success', trans('seat-industry::ai-settings.update_settings_success'));

        return redirect()->route('seat-industry.settings');
    }
}
