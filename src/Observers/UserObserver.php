<?php

namespace HermesDj\Seat\Industry\Observers;

use HermesDj\Seat\Industry\Models\Delivery;
use HermesDj\Seat\Industry\Models\Order;

class UserObserver
{

    public static function deleted($user){
        $deliveries = Delivery::where("user_id", $user->id)->pluck("id");
        Delivery::destroy($deliveries);

        $orders = Order::where("user_id", $user->id)->pluck("id");
        Order::destroy($orders);
    }
}