<?php

namespace HermesDj\Seat\Industry\Notifications;

use HermesDj\Seat\Industry\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
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
            ->action(trans('seat-industry::ai-config.notification_mail_action'), route("Industry.orders"));

        $message->salutation(trans('seat-industry::ai-config.notification_mail_salutation'));

        return $message;
    }
}