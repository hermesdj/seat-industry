<?php

namespace Seat\HermesDj\Industry\Notifications\Expiration;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Seat\Notifications\Notifications\AbstractDiscordNotification;
use Seat\Notifications\Services\Discord\Messages\DiscordEmbed;
use Seat\Notifications\Services\Discord\Messages\DiscordMessage;

class ExpiringOrderNotificationDiscord extends AbstractDiscordNotification implements ShouldQueue
{
    use SerializesModels;

    private Collection $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    protected function populateMessage(DiscordMessage $message, $notifiable): void
    {
        $orders = $this->orders;

        $message->success()
            ->embed(function (DiscordEmbed $embed) use ($orders) {
                $embed
                    ->author('Seat Industry')
                    ->title(
                        trans(
                            'seat-industry::ai-orders.notifications.expiring_orders', ['count' => $orders->count()]
                        ),
                    );

                foreach ($orders as $order) {
                    $time = CarbonInterval::seconds(Carbon::now()->diffInSeconds($order->produce_until))->forHumans(null, true, 2);
                    $reference = $order->reference;
                    $url = route('seat-industry.orderDetails', ['order' => $order->id]);
                    $embed->field(trans('seat-industry::ai-orders.notifications.reference'), "[$reference]($url)");
                    $embed->field(trans('seat-industry::ai-orders.notifications.remaining'), $time);
                    $embed->field('\u200B', '\u200B');
                }
            });
    }
}
