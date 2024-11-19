<?php

namespace HermesDj\Seat\Industry\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use HermesDj\Seat\Industry\Helpers\IndustryHelper;
use HermesDj\Seat\Industry\Models\OrderItem;
use Seat\Notifications\Notifications\AbstractDiscordNotification;
use Seat\Notifications\Services\Discord\Messages\DiscordEmbed;
use Seat\Notifications\Services\Discord\Messages\DiscordMessage;

class OrderNotificationDiscord extends AbstractDiscordNotification implements ShouldQueue
{
    use SerializesModels;

    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    protected function populateMessage(DiscordMessage $message, $notifiable)
    {
        $order = $this->order;

        $message->success()
            ->embed(function (DiscordEmbed $embed) use ($order) {
                $charId = $order->user->main_character->id;

                $embed
                    ->author($order->user->name, "https://images.evetech.net/characters/$charId/portrait?size=64")
                    ->title(trans('seat-industry::ai-orders.notifications.new_order', ['code' => $order->order_id]), route('Industry.orderDetails', ['id' => $order->id]))
                    ->description(OrderItem::formatOrderItemsForDiscord($order))
                    ->field(trans('seat-industry::ai-orders.notifications.reference'), $order->reference)
                    ->field(trans('seat-industry::ai-orders.notifications.order_price'), IndustryHelper::formatNumber($order->totalValue()) . ' ISK')
                    ->field(trans('seat-industry::ai-orders.notifications.nb_items'), $order->items->count())
                    ->field(trans('seat-industry::ai-orders.notifications.location'), $order->location()->name);
            });
    }
}