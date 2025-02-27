<?php

namespace Seat\HermesDj\Industry\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Seat\HermesDj\Industry\IndustrySettings;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Notifications\Models\NotificationGroup;
use Seat\Notifications\Traits\NotificationDispatchTool;

class SendExpiredOrderNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, NotificationDispatchTool, Queueable, SerializesModels;

    public function tags(): array
    {
        return ['seat-industry', 'order', 'notifications'];
    }

    public function handle(): void
    {
        $now = Carbon::now();
        $last_expiring = IndustrySettings::$LAST_EXPIRING_NOTIFICATION_BATCH->get();

        if ($last_expiring === null) {
            $expiring_orders = Order::where('confirmed', true)
                ->where('completed', false)
                ->where('produce_until', '<', $now->addHours(24))
                ->get();
        } else {
            $expiring_orders = Order::where('confirmed', true)
                ->where('completed', false)
                ->where('produce_until', '<', Carbon::parse($last_expiring)->addHours(24))
                ->get();
        }

        if (! $expiring_orders->isEmpty()) {
            $this->dispatchExpiringOrderNotification($expiring_orders);
        }

        IndustrySettings::$LAST_EXPIRING_NOTIFICATION_BATCH->set($now->addHours(24)->toIso8601String());
    }

    private function dispatchExpiringOrderNotification($orders): void
    {
        $groups = NotificationGroup::with('alerts')
            ->whereHas('alerts', function ($query) {
                $query->where('alert', 'seat_industry_expiring_order_notification');
            })->get();

        $this->dispatchNotifications('seat_industry_expiring_order_notification', $groups, function ($constructor) use ($orders) {
            return new $constructor($orders);
        });
    }
}
