<?php

return [
    [
        'name' => 'details',
        'label' => 'seat-industry::ai-orders.order_menu.details',
        'permission' => 'seat-industry.create_orders',
        'highlight_view' => 'details',
        'route' => 'seat-industry.orderDetails',
    ],
    [
        'name' => 'deliveryDetails',
        'label' => 'seat-industry::ai-orders.order_menu.deliveries',
        'permission' => 'seat-industry.create_orders',
        'highlight_view' => 'deliveryDetails',
        'route' => 'seat-industry.orderDeliveryDetails',
    ],
    [
        'name' => 'ravworks',
        'label' => 'seat-industry::ai-orders.order_menu.ravworks',
        'permission' => 'seat-industry.create_deliveries',
        'highlight_view' => 'ravworks',
        'route' => 'seat-industry.ravworksDetails',
    ],
    [
        'name' => 'buildPlan',
        'label' => 'seat-industry::ai-orders.order_menu.build_plan',
        'permission' => 'seat-industry.create_deliveries',
        'highlight_view' => 'buildPlan',
        'route' => 'seat-industry.buildPlan',
    ],
];
