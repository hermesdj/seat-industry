<?php

namespace Seat\HermesDj\Industry\Jobs;

use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Notifications\Models\NotificationGroup;
use Seat\Notifications\Traits\NotificationDispatchTool;

class SendOrderNotification
{
    use NotificationDispatchTool;

    private Order $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public static function dispatch($order): void
    {
        $notification = new SendOrderNotification($order);
        $notification->dispatchNotification();
    }

    // stolen from https://github.com/eveseat/notifications/blob/master/src/Observers/UserObserver.php
    private function dispatchNotification(): void
    {
        $order = $this->order;

        $groups = NotificationGroup::with('alerts')
            ->whereHas('alerts', function ($query) {
                $query->where('alert', 'seat_industry_new_order_notification');
            })->get();

        $this->dispatchNotifications('seat_industry_new_order_notification', $groups, function ($constructor) use ($order) {
            return new $constructor($order);
        });
    }
}
