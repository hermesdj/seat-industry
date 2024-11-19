<?php

namespace HermesDj\Seat\Industry\Observers;

use HermesDj\Seat\Industry\Models\Statistics\OrderStatistic;

class OrderObserver
{
    public static function deleted($order)
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