<?php

use HermesDj\Seat\Industry\Notifications\Expiration\ExpiringOrderNotificationDiscord;
use HermesDj\Seat\Industry\Notifications\OrderNotificationDiscord;
use HermesDj\Seat\Industry\Notifications\OrderNotificationMail;
use HermesDj\Seat\Industry\Notifications\OrderNotificationSlack;

return [
    'seat_alliance_industry_new_order_notification' => [
        'label' => 'seat-industry::ai-config.seat_alliance_industry_new_order_notification',
        'handlers' => [
            'mail' => OrderNotificationMail::class,
            'slack' => OrderNotificationSlack::class,
            'discord' => OrderNotificationDiscord::class
        ],
    ],
    'seat_alliance_industry_expiring_order_notification' => [
        'label' => 'seat-industry::ai-config.seat_alliance_industry_expiring_order_notification',
        'handlers' => [
            'discord' => ExpiringOrderNotificationDiscord::class
        ],
    ]
];