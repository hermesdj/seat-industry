<?php

use Seat\HermesDj\Industry\Models\Orders\Order;

return [
    [
        'name' => 'myOrders',
        'label' => 'seat-industry::ai-orders.orders_menu.my_orders',
        'permission' => 'seat-industry.create_orders',
        'highlight_view' => 'myOrders',
        'route' => 'seat-industry.myOrders',
        'badgeValueClass' => Order::class,
        'badgeValueMethod' => 'countPersonalOrders',
    ],
    [
        'name' => 'available',
        'label' => 'seat-industry::ai-orders.orders_menu.available',
        'permission' => 'seat-industry.view_orders',
        'highlight_view' => 'available',
        'route' => 'seat-industry.orders',
        'badgeValueClass' => Order::class,
        'badgeValueMethod' => 'countAvailableOrders',
    ],
    [
        'name' => 'corporationOrders',
        'label' => 'seat-industry::ai-orders.orders_menu.reserved_corp',
        'permission' => 'seat-industry.corp_delivery',
        'highlight_view' => 'corporationOrders',
        'route' => 'seat-industry.corporationOrders',
        'badgeValueClass' => Order::class,
        'badgeValueMethod' => 'countCorporationOrders',
    ],
];
