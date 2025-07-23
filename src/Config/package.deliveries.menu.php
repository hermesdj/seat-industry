<?php

use Seat\HermesDj\Industry\Models\Deliveries\Delivery;

return [
    [
        'name' => 'myUnfulfilledDeliveries',
        'label' => 'seat-industry::ai-deliveries.deliveries_menu.my_deliveries',
        'permission' => 'seat-industry.create_deliveries',
        'highlight_view' => 'myUnfulfilledDeliveries',
        'route' => 'seat-industry.myUnfulfilledDeliveries',
        'badgeValueClass' => Delivery::class,
        'badgeValueMethod' => 'countMyUnfulfilledDeliveries',
    ],
    [
        'name' => 'allDeliveries',
        'label' => 'seat-industry::ai-deliveries.deliveries_menu.all_deliveries',
        'permission' => 'seat-industry.manager',
        'highlight_view' => 'allDeliveries',
        'route' => 'seat-industry.allDeliveries',
        'badgeValueClass' => Delivery::class,
        'badgeValueMethod' => 'countAllDeliveries',
    ],
];
