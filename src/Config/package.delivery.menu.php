<?php

return [
    [
        'name' => 'details',
        'label' => 'seat-industry::ai-deliveries.delivery_menu.details',
        'permission' => 'seat-industry.view_orders',
        'highlight_view' => 'details',
        'route' => 'seat-industry.deliveryDetails'
    ],
    [
        'name' => 'ravworks',
        'label' => 'seat-industry::ai-deliveries.delivery_menu.ravworks',
        'permission' => 'seat-industry.view_orders',
        'highlight_view' => 'ravworks',
        'route' => 'seat-industry.deliveryRavworksDetails'
    ],
    [
        'name' => 'buildPlan',
        'label' => 'seat-industry::ai-deliveries.delivery_menu.build_plan',
        'permission' => 'seat-industry.view_orders',
        'highlight_view' => 'buildPlan',
        'route' => 'seat-industry.deliveryBuildPlan'
    ]
];