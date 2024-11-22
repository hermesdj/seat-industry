<?php

namespace Seat\HermesDj\Industry\Observers;

use Seat\HermesDj\Industry\Models\Deliveries\Delivery;
use Seat\HermesDj\Industry\Models\Orders\Order;

class UserObserver
{

    public static function deleted($user): void
    {
        $deliveries = Delivery::where("user_id", $user->id)->pluck("id");
        Delivery::destroy($deliveries);

        $orders = Order::where("user_id", $user->id)->pluck("id");
        Order::destroy($orders);
    }
}