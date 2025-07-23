<?php

return [
    'Industry' => [
        'name' => 'Industry',
        'label' => 'seat-industry::ai-common.menu.title',
        'icon' => 'fas fa-industry',
        'route_segment' => 'seat-industry',
        'permission' => 'seat-industry.create_orders',
        'entries' => [
            [
                'name' => 'Create Order',
                'label' => 'seat-industry::ai-common.menu.create_order',
                'icon' => 'fas fa-cart-plus',
                'route' => 'seat-industry.createOrder',
                'permission' => 'seat-industry.create_orders',
            ],
            [
                'name' => 'Orders',
                'label' => 'seat-industry::ai-common.menu.orders',
                'icon' => 'fas fa-list',
                'route' => 'seat-industry.myOrders',
                'permission' => 'seat-industry.create_orders',
            ],
            [
                'name' => 'Deliveries',
                'label' => 'seat-industry::ai-common.menu.deliveries',
                'icon' => 'fas fa-truck',
                'route' => 'seat-industry.myUnfulfilledDeliveries',
                'permission' => 'seat-industry.create_deliveries',
            ],
            [
                'name' => 'Scoreboard',
                'label' => 'seat-industry::ai-common.menu.scoreboard',
                'icon' => 'fas fa-trophy',
                'route' => 'seat-industry.scoreboard',
                'permission' => 'seat-industry.view_scoreboard',
            ],
            [
                'name' => 'Profiles',
                'label' => 'seat-industry::ai-common.menu.profiles',
                'icon' => 'fas fa-industry',
                'route' => 'seat-industry.profiles',
                'permission' => 'seat-industry.create_orders',
            ],
            [
                'name' => 'Settings',
                'label' => 'seat-industry::ai-common.menu.settings',
                'icon' => 'fas fa-cogs',
                'route' => 'seat-industry.settings',
                'permission' => 'seat-industry.settings',
            ],
            [
                'name' => 'About',
                'label' => 'seat-industry::ai-common.menu.about',
                'icon' => 'fas fa-info',
                'route' => 'seat-industry.about',
                'permission' => 'seat-industry.create_orders',
            ],
        ],
    ],
];
