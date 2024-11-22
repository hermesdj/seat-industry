<?php

namespace Seat\HermesDj\Industry\Observers;

use Seat\HermesDj\Industry\Models\Statistics\OrderStatistic;

class OrderObserver
{
    public static function deleted($order): void
    {
        foreach ($order->deliveries as $delivery) {
            $delivery->delete();
        }
        foreach ($order->items as $item) {
            $item->delete();
        }

        OrderStatistic::create([
            'order_id' => $order->id,
            'created_at' => $order->created_at,
            'completed_at' => $order->completed_at
        ]);
    }
}