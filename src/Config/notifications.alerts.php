<?php

use Seat\HermesDj\Industry\Notifications\Creation\OrderNotificationDiscord;
use Seat\HermesDj\Industry\Notifications\Creation\OrderNotificationMail;
use Seat\HermesDj\Industry\Notifications\Creation\OrderNotificationSlack;
use Seat\HermesDj\Industry\Notifications\Expiration\ExpiringOrderNotificationDiscord;

return [
    'seat_industry_new_order_notification' => [
        'label' => 'seat-industry::ai-config.seat_industry_new_order_notification',
        'handlers' => [
            'mail' => OrderNotificationMail::class,
            'slack' => OrderNotificationSlack::class,
            'discord' => OrderNotificationDiscord::class,
        ],
    ],
    'seat_industry_expiring_order_notification' => [
        'label' => 'seat-industry::ai-config.seat_industry_expiring_order_notification',
        'handlers' => [
            'discord' => ExpiringOrderNotificationDiscord::class,
        ],
    ],
];
