<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Stocks;


use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Web\Models\User;

class StocksHelper
{
    public static function computePersonalStocks(User $user, Order $order): CharacterStocks
    {
        $stocks = CharacterStocks::init($order, $user);
        $stocks->queryContainers();
        $stocks->queryAssets();

        return $stocks;
    }

    public static function computeCorporationStocks(int $corporation_id, Order $order): CorporationStocks
    {
        $stocks = CorporationStocks::init($corporation_id, $order);
        $stocks->queryContainers();
        $stocks->queryAssets();

        return $stocks;
    }
}