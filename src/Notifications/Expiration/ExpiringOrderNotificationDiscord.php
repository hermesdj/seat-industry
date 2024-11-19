<?php

namespace HermesDj\Seat\Industry\Notifications\Expiration;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use HermesDj\Seat\Industry\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use HermesDj\Seat\Industry\Helpers\IndustryHelper;
use HermesDj\Seat\Industry\Models\OrderItem;
use Seat\Notifications\Notifications\AbstractDiscordNotification;
use Seat\Notifications\Services\Discord\Messages\DiscordEmbed;
use Seat\Notifications\Services\Discord\Messages\DiscordMessage;

class ExpiringOrderNotificationDiscord extends AbstractDiscordNotification implements ShouldQueue
{
    use SerializesModels;

    private Order $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    protected function populateMessage(DiscordMessage $message, $notifiable): void
    {
        $order = $this->order;

        $message->success()
            ->embed(function (DiscordEmbed $embed) use ($order) {
                $charId = $order->user->main_character->id;

                $embed
                    ->author($order->user->name, "https://images.evetech.net/characters/$charId/portrait?size=64")
                    ->title(trans('seat-industry::ai-orders.notifications.expiring_order', ['code' => $order->order_id]), route('Industry.orderDetails', ['id' => $order->id]))
                    ->description(trans('seat-industry::ai-orders.notifications.expiring_message', ['remaining' => CarbonInterval::seconds(Carbon::now()->diffInSeconds($order->produce_until))]))
                    ->field(trans('seat-industry::ai-orders.notifications.reference'), $order->reference)
                    ->field(trans('seat-industry::ai-orders.notifications.order_price'), IndustryHelper::formatNumber($order->totalValue()) . ' ISK')
                    ->field(trans('seat-industry::ai-orders.notifications.nb_items'), $order->items->count())
                    ->field(trans('seat-industry::ai-orders.notifications.location'), $order->location()->name);
            });
    }
}