<?php

return [
    'seat_alliance_industry_new_order_notification' => 'New Industry order',
    'seat_alliance_industry_expiring_order_notification' => 'Industry order expiring',
    'new_orders_are_available' => 'New Industry orders are available !',
    'build_time_price_provider' => 'Item Manufacturing Time',

    'notification_from' => 'SeAT Industry',

    'notification_mail_subject' => 'New Industry Orders',
    'notification_mail_greeting' => 'Hello Industrialist',
    'notification_mail_line' => 'New industry orders have been put up.',
    'notification_mail_action' => 'View on SeAT',
    'notification_mail_salutation' => 'Regards, the seat-industry plugin',

    'permissions' => [
        'view_orders_label' => 'View Orders',
        'view_orders_desc' => 'Allows you to view orders',

        'create_deliveries_label' => 'Complete Orders',
        'create_deliveries_desc' => 'Allows you to sign up to complete orders',

        'create_orders_label' => 'Create Orders',
        'create_orders_desc' => 'Allows you to order products',

        'create_repeating_orders_label' => 'Create repeating Orders',
        'create_repeating_orders_desc' => 'Allows you to create orders that appear every x days',

        'admin_label' => 'Plugin Admin',
        'admin_desc' => 'Allows you to edit other\'s orders',

        'settings_label' => 'Plugin Settings',
        'settings_desc' => 'Allows you to edit change plugin settings',

        'inventory_label' => 'Add to Seat Inventory',
        'inventory_desc' => 'Allow the user to add an order as a SeAT Inventory source.',

        'priority_label' => 'Manage Order Priority',
        'priority_desc' => 'Allow a user to set a priority on an order',

        'corp_delivery_label' => 'Corp Delivery',
        'corp_delivery_desc' => 'Allow to reserve the delivery of an order in the name of the corporation of the user',

        'change_price_provider' => [
            'label' => 'Change Price Provider',
            'desc' => 'Allow the user to change the price provider on an order'
        ],

        'update_stocks' => [
            'label' => 'Update Stocks',
            'description' => 'Allow the user to trigger update assets & assets names to sync stocks for an order'
        ],

        'view_scoreboard' => [
            'label' => 'View Scoreboard',
            'description' => 'Allow the user to consult the scoreboard'
        ]
    ],
];
