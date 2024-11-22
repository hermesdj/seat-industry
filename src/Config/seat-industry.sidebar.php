<?php

return [
    'Industry' => [
        'name' => 'Industry',
        'label' => 'seat-industry::ai-common.menu_title',
        'icon' => 'fas fa-industry',
        'route_segment' => 'seat-industry',
        'permission' => 'seat-industry.view_orders',
        'entries' => [
            [
                'name' => 'Create Order',
                'label' => 'seat-industry::ai-common.menu_create_order',
                'icon' => 'fas fa-cart-plus',
                'route' => 'seat-industry.createOrder',
                'permission' => 'seat-industry.create_orders',
            ],
            [
                'name' => 'Orders',
                'label' => 'seat-industry::ai-common.menu_orders',
                'icon' => 'fas fa-list',
                'route' => 'seat-industry.orders',
                'permission' => 'seat-industry.view_orders',
            ],
            [
                'name' => 'Deliveries',
                'label' => 'seat-industry::ai-common.menu_deliveries',
                'icon' => 'fas fa-truck',
                'route' => 'seat-industry.deliveries',
                'permission' => 'seat-industry.view_orders',
            ],
            [
                'name' => 'Settings',
                'label' => 'seat-industry::ai-common.menu_settings',
                'icon' => 'fas fa-cogs',
                'route' => 'seat-industry.settings',
                'permission' => 'seat-industry.settings',
            ],
            [
                'name' => 'About',
                'label' => 'seat-industry::ai-common.menu_about',
                'icon' => 'fas fa-info',
                'route' => 'seat-industry.about',
                'permission' => 'seat-industry.view_orders',
            ],
        ],
    ],
];
