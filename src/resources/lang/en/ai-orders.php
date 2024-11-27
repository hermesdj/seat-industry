<?php

return [
    'create_order_title' => 'Create Order',

    'order_title' => 'Order N°:code - :reference',
    'orders_title' => 'Orders',
    'order_reference' => 'Order Reference',
    'your_orders_title' => 'Your Orders',

    'order_menu' => [
        'details' => 'Order Details',
        'deliveries' => 'Deliveries',
        'ravworks' => 'Ravworks',
        'build_plan' => 'Build Plan',
    ],

    'orders_menu' => [
        'available' => 'Disponible',
        'reserved_corp' => 'Réservées Corporation',
        'my_orders' => 'Mes Commandes',
    ],

    'repeating_order_title' => 'Repeating Order',
    'repeating_order_desc' => 'This is a order repeating itself every :days days. The next repetition will be published on the :date.',

    'items_label' => 'Order Items',
    'items_placeholder' => "MULTIBUY:\nTristan 100\nOmen 100\nTritanium 30000\n\nFITTINGS:\n[Pacifier, 2022 Scanner]\n\nCo-Processor II\nCo-Processor II\n\nMultispectrum Shield Hardener II\nMultispectrum Shield Hardener II\n\nSmall Tractor Beam II\nSmall Tractor Beam II",

    'reward_label' => 'Reward %',
    'reward_hint' => 'The minimal profit is :mpp% and will be added to the price automatically computed. Set a profit higher to incentive producer to handle the order faster',
    'add_profit_to_manual_prices_label' => 'Add Reward to Manual Prices',

    'days_to_complete_label' => 'Days to complete',

    'location_label' => 'Location',
    'priority_label' => 'Priority',
    'priority_Very Low' => 'Very Low',
    'priority_Low' => 'Low',
    'priority_Normal' => 'Normal',
    'priority_Preferred' => 'Preferred',
    'priority_Important' => 'Important',
    'priority_Critical' => 'Critical',
    'time_label' => 'Time',
    'time_hint' => 'Will add the value in days to the current order delivery date.',

    'no_delivery' => 'No delivery',

    'quantity_label' => 'Quantity',
    'quantity_hint' => 'The number of times to multiply every items with. Useful to order multiple ship fits for example',

    'reference_label' => 'Reference',
    'reference_hint' => 'Provide a name for this order. Leaving empty will fill the name with the generated order code. If a fit is provided in the text field below, and this field is empty, the name of the fit will be set as reference.',

    'seat_inventory_label' => 'Seat-Inventory',
    'seat_inventory_hint' => 'Add as source to seat-inventory',
    'seat_inventory_desc' => 'As soon as a delivery for this order is created, a item source will be added to seat-inventory. Once the delivery is marked as completed, the source will be removed. The source will be added to the <u>first</u> workspace containing <code>add2Industry</code> at any position in it\'s name. You can rename workspaces <a href=":route">here.</a>',

    'deliver_to_label' => 'Deliver To',
    'deliver_to_hint' => 'Select the character this order should be delivered to',

    'repetition_label' => 'Repetition',
    'repetition_never' => 'Never',
    'repetition_weekly' => 'Weekly',
    'repetition_every_two_weeks' => 'Every 2 weeks',
    'repetition_monthly' => 'Monthly',

    'add_order_btn' => 'Add Order',

    'invalid_order_label' => 'invalid order',

    'close_order_btn' => 'Close',
    'update_price_btn' => 'Update Price',
    'update_price_action' => 'update the price? Manual prices will be overwritten!',
    'extend_time_btn' => 'Extend Time',
    'extend_time_action' => ' want to expand the time to deliver by 1 week',

    // Marketplace
    'order_marketplace_title' => 'Order Marketplace',
    'open_orders_title' => 'Open Orders',

    'empty_deliveries' => 'There are no deliveries yet.',

    'close_all_completed_orders_btn' => 'Close all completed Orders',

    'create_order_success' => 'Successfully added new order',
    'update_time_success' => 'Extended the time!',
    'update_price_success' => 'Updated the price!',
    'close_order_success' => 'Successfully closed order!',

    'order_id' => 'Order Code',
    'reserve_corp_btn' => 'Reserve Corp',
    'confirm_order_btn' => 'Confirm',

    'list' => [
        'titles' => [
            'available' => 'Available',
            'corporation' => 'Corporation',
            'my' => 'My Orders',
        ],
    ],

    'status' => [
        'available' => 'Available',
        'unconfirmed' => 'Unconfirmed',
    ],

    'btns' => [
        'updateOrderItemStates' => 'Calcul Etat Lignes',
        'reserveCorp' => 'Reserve Corp',
        'unReserveCorp' => 'Not Reserve Corp',
        'deleteOrder' => 'Delete Order',
        'completeOrder' => 'Complete Order',
    ],

    'items' => [
        'title' => [
            'accepted' => 'Accepted Items',
            'rejected' => 'Rejected Items',
        ],
        'headers' => [
            'type' => 'Item',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total' => 'Total',
        ],
    ],

    'fields' => [
        'date' => 'Date',
        'code' => 'Order N°',
        'location' => 'Location',
        'quantities' => 'Total Quantities',
        'corporation' => 'Reserved By',
        'reference' => 'Reference',
    ],

    'summary' => [
        'title' => 'Summary',
        'order_total' => 'Total Ordered',
        'in_delivery' => 'In Delivery',
        'delivered' => 'Delivered',
        'remaining' => 'Remaining',
        'rejected' => 'Rejected',
    ],

    'notifications' => [
        'new_order' => 'New Order :code is available !',
        'order_details' => 'Order details :',
        'order_price' => 'Price',
        'nb_items' => 'Nb Items',
        'location' => 'Location',
        'reference' => 'Reference',
        'expiring_order' => 'Order :code Expiration !',
        'expiring_message' => 'This order will expire in :remaining !',
    ],

    'modals' => [
        'editPrices' => [
            'title' => 'Edit Order :code prices',
            'desc' => 'This modal allow you to recompute an order prices with up to date price data from the price providers.',
        ],
        'editTime' => [
            'title' => 'Extend Order :code delivery date',
            'desc' => 'This modal allow you to extend the time of the order by adding more days to the current value.',
        ],
    ],

    'ravworks' => [
        'export' => [
            'btn' => 'Ravworks Export',
        ],
    ],

    'messages' => [
        'order_items_state_updated' => 'Items states have been successfully updated !',
    ],
];
