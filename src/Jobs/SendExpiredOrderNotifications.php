<?php

namespace HermesDj\Seat\Industry\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use HermesDj\Seat\Industry\IndustrySettings;
use HermesDj\Seat\Industry\Models\Order;
use Seat\Notifications\Models\NotificationGroup;
use Seat\Notifications\Traits\NotificationDispatchTool;

class SendExpiredOrderNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, NotificationDispatchTool;

    public function tags(): array
    {
        return ["seat-industry", "order", "notifications"];
    }

    public function handle(): void
    {
        $now = now();
        $last_expiring = IndustrySettings::$LAST_EXPIRING_NOTIFICATION_BATCH->get();

        if ($last_expiring === null) {
            $expiring_orders = Order::where("confirmed", true)
                ->where('completed', false)
                ->where('produce_until', '<', $now->addHours(24))
                ->get();
        } else {
            $expiring_orders = Order::where("confirmed", true)
                ->where('completed', false)
                ->where('produce_until', '<', $last_expiring->addHours(24))
                ->get();
        }

        if (!$expiring_orders->isEmpty()) {
            foreach ($expiring_orders as $order) {
                $this->dispatchExpiringOrderNotification($order);
            }
        }

        IndustrySettings::$LAST_EXPIRING_NOTIFICATION_BATCH->set($now->addHours(24));
    }

    private function dispatchExpiringOrderNotification($order): void
    {
        $groups = NotificationGroup::with('alerts')
            ->whereHas('alerts', function ($query) {
                $query->where('alert', 'seat_alliance_industry_expiring_order_notification');
            })->get();

        $this->dispatchNotifications("seat_alliance_industry_expiring_order_notification", $groups, function ($constructor) use ($order) {
            return new $constructor($order);
        });
    }
}