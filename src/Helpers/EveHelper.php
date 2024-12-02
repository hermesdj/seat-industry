<?php

namespace Seat\HermesDj\Industry\Helpers;

class EveHelper
{
    public static function formatOrderItemsToBuyAll($items)
    {
        return $items
            ->map(function ($item) {
            return self::formatItemToBuyAll($item->type->typeName, $item->quantity - $item->assignedQuantity());
        })->join("\n");
    }

    private static function formatItemToBuyAll($name, $quantity): string
    {
        $line = collect();

        $line->push($name);
        $line->push($quantity);

        return $line->join(' ');
    }
}
