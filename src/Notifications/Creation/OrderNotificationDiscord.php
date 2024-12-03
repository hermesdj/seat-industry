<?php

namespace Seat\HermesDj\Industry\Notifications\Creation;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Seat\HermesDj\Industry\Helpers\OrderHelper;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\HermesDj\Industry\Models\Orders\OrderItem;
use Seat\Notifications\Notifications\AbstractDiscordNotification;
use Seat\Notifications\Services\Discord\Messages\DiscordEmbed;
use Seat\Notifications\Services\Discord\Messages\DiscordMessage;

class OrderNotificationDiscord extends AbstractDiscordNotification implements ShouldQueue
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

                if ($order->corporation) {
                    $embed->title(trans('seat-industry::ai-orders.notifications.new_corp_order', ['code' => $order->order_id, 'reference' => $order->reference]), route('seat-industry.orderDetails', ['order' => $order->id]));
                } else {
                    $embed->title(trans('seat-industry::ai-orders.notifications.new_order', ['code' => $order->order_id, 'reference' => $order->reference]), route('seat-industry.orderDetails', ['order' => $order->id]));
                }

                $embed
                    ->author($order->user->name, "https://images.evetech.net/characters/$charId/portrait?size=64")
                    ->description(OrderItem::formatOrderItemsForDiscord($order))
                    ->field(trans('seat-industry::ai-orders.notifications.reference'), $order->reference)
                    ->field(trans('seat-industry::ai-orders.notifications.order_price'), OrderHelper::formatNumber($order->totalValue()) . ' ISK')
                    ->field(trans('seat-industry::ai-orders.notifications.nb_items'), $order->items->count())
                    ->field(trans('seat-industry::ai-orders.notifications.location'), $order->location()->name);

                if ($order->corporation) {
                    $embed->field(trans('seat-industry::ai-orders.notifications.reserved_corp'), $order->corporation->name);
                }
            });
    }
}
