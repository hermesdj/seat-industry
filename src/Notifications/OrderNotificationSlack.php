<?php

namespace HermesDj\Seat\Industry\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Queue\SerializesModels;
use HermesDj\Seat\Industry\IndustrySettings;
use HermesDj\Seat\Industry\Models\OrderItem;
use HermesDj\Seat\TreeLib\Helpers\PrioritySystem;
use Seat\Notifications\Notifications\AbstractSlackNotification;

class OrderNotificationSlack extends AbstractSlackNotification implements ShouldQueue
{
    use SerializesModels;

    private $order;

    public function __construct($order)
    {
        $this->orders = $order;
    }

    public function populateMessage(SlackMessage $message, $notifiable)
    {
        $order = $this->order;

        $pings = implode(" ", array_map(function ($role) {
            return "<@&$role>";
        }, IndustrySettings::$ORDER_CREATION_PING_ROLES->get([])));

        $message
            ->success()
            ->from(trans('seat-industry::ai-config.notification_from'));

        if ($pings !== "") {
            $message->content($pings);
        }

        $message->attachment(function ($attachment) use ($order) {
            $attachment
                ->title(trans('seat-industry::ai-config.seat_alliance_industry_new_order_notification'), route("Industry.orders"));

            $item_text = OrderItem::formatOrderItemsList($order);
            $location = $order->location()->name;
            $price = number_metric($order->price);
            $totalPrice = number_metric($order->price * $order->quantity);
            $priorityName = PrioritySystem::getPriorityData()[$order->priority]["name"];
            $priority = $priorityName ? trans("seat-industry::ai-orders.priority_$priorityName") : trans("seat.web.unknown");

            $attachment->field(function ($field) use ($item_text, $priority, $totalPrice, $price, $location) {
                $field
                    ->long()
                    ->title($item_text)
                    ->content(trans('seat-industry::ai-common.notifications_field_description', [
                        'priority' => $priority,
                        'price' => $price,
                        'totalPrice' => $totalPrice,
                        'location' => $location
                    ]));
            });
        });
        return $message;
    }
}