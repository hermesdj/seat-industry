<?php

namespace Seat\HermesDj\Industry\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Notifications\Notifications\AbstractMailNotification;

class OrderNotificationMail extends AbstractMailNotification implements ShouldQueue
{
    use SerializesModels;

    private Order $order;

    public function __construct($order)
    {
        $this->orders = $order;
    }

    public function populateMessage(MailMessage $message, $notifiable): MailMessage
    {

        $message->success()
            ->subject(trans('seat-industry::ai-config.notification_mail_subject'))
            ->greeting(trans('seat-industry::ai-config.notification_mail_greeting'))
            ->line(trans('seat-industry::ai-config.notification_mail_line'))
            ->action(trans('seat-industry::ai-config.notification_mail_action'), route("seat-industry.orders"));

        $message->salutation(trans('seat-industry::ai-config.notification_mail_salutation'));

        return $message;
    }
}