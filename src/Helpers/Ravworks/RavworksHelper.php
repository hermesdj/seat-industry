<?php

namespace Seat\HermesDj\Industry\Helpers\Ravworks;

use Illuminate\Support\Collection;
use Seat\HermesDj\Industry\Helpers\Industry\BuildPlan;
use Seat\HermesDj\Industry\Helpers\Industry\EndProductItem;

class RavworksHelper
{
    public static function printOrderBuildPlanHtml(BuildPlan $buildPlan): string
    {
        return $buildPlan->getEndProducts()->map(function ($line) {
            return self::buildProductLineToString($line);
        })->join('<br />');
    }

    public static function printOrderBuildPlanText(BuildPlan $buildPlan): string
    {
        return $buildPlan->getEndProducts()->map(function ($line) {
            return self::buildProductLineToString($line);
        })->join("\n");
    }

    private static function buildProductLineToString(EndProductItem $endProduct): string
    {
        $line = collect();

        $line->push($endProduct->productName);
        $line->push($endProduct->nbRuns);
        $line->push($endProduct->materialEfficiency);

        if ($endProduct->nbTasks > 1) {
            $line->push("x" . $endProduct->nbTasks);
        }

        return $line->join(' ');
    }

    public static function printPersonalOrderStocksHtml(BuildPlan $buildPlan): string
    {
        return $buildPlan->getPersonalStocks()->stocks->map(function (Collection $assets) {
            return self::buildStockToString($assets);
        })->join('<br />');
    }

    public static function printPersonalOrderStocksText(BuildPlan $buildPlan): string
    {
        return $buildPlan->getPersonalStocks()->stocks->map(function (Collection $assets) {
            return self::buildStockToString($assets);
        })->join("\n");
    }

    public static function printCorporationOrderStocksHtml(BuildPlan $buildPlan): string
    {
        return $buildPlan->getCorporationStocks()->stocks->map(function (Collection $assets) {
            return self::buildStockToString($assets);
        })->join('<br />');
    }

    public static function printCorporationOrderStocksText(BuildPlan $buildPlan): string
    {
        return $buildPlan->getCorporationStocks()->stocks->map(function (Collection $assets) {
            return self::buildStockToString($assets);
        })->join("\n");
    }

    public static function buildStockToString(Collection $items): string
    {
        if ($items->count() == 0) return '';
        $item = $items->first();

        $line = collect();

        $line->push($item->typeName);
        $line->push($items->reduce(function ($acc, $item) {
            return $acc + $item->quantity;
        }, 0));

        return $line->join(' ');
    }
}