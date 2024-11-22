<?php

namespace Seat\HermesDj\Industry\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Seat\HermesDj\Industry\Models\Orders\Order;

class UpdateRepeatingOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function tags(): array
    {
        return ['seat-industry', 'order', 'repeating'];
    }

    public function handle(): void
    {
        $orders = Order::where('is_repeating', true)
            ->where('repeat_date', '<', now())
            ->get();

        foreach ($orders as $order) {
            $order->repeat_date = carbon($order->repeat_date)->addDays($order->repeat_interval);
            $order->save();
            $this->copyOrder($order);
        }
    }

    public function copyOrder($src): void
    {
        $order = $src->replicate();
        $order->is_repeating = false;
        $order->repeat_interval = null;
        $order->repeat_date = null;
        $order->created_at = now();
        $order->produce_until = now()->addDays($src->repeat_interval);
        $order->save();

        foreach ($src->items as $item_src) {
            $item = $item_src->replicate();
            $item->order_id = $order->id;
            $item->save();
        }
    }
}
