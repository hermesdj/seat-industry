<?php

namespace HermesDj\Seat\Industry\Helpers;

use HermesDj\Seat\Industry\IndustrySettings;
use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;
use Seat\Services\Settings\Profile;

class IndustryHelper
{
    public static function generateRandomString(int $length = 25): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function formatNumber($value, $decimals = 2): string
    {
        $thousandSeparator = Profile::get('thousand_separator');
        $decimalSeparator = Profile::get('decimal_separator');

        return number_format($value, $decimals, $decimalSeparator, $thousandSeparator);
    }

    public static function filteredPriceProviders(): array
    {
        if (is_array(IndustrySettings::$ALLOWED_PRICE_PROVIDERS->get())) {
            return PriceProviderInstance::whereIn('id', IndustrySettings::$ALLOWED_PRICE_PROVIDERS->get())->get()->all();
        } else {
            $defaultPriceProvider = PriceProviderInstance::where('id', IndustrySettings::$DEFAULT_PRICE_PROVIDER->get())->first();
            return [$defaultPriceProvider];
        }
    }
}