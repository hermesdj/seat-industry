<?php

return [
    'menu_title' => 'Industry',
    'menu_orders' => 'Orders',
    'menu_deliveries' => 'Deliveries',
    'menu_settings' => 'Settings',
    'menu_about' => 'About',
    'menu_create_order' => 'Create Order',

    'cancel' => 'Cancel',
    'back' => 'Back',

    'price_provider_label' => 'Price Provider',
    'price_provider_hint' => 'The source of the prices used to calculate the order price.',
    'price_provider_create_success' => 'Successfully created price provider.',

    'amount_header' => 'Quantity',
    'completion_header' => 'Completed',
    'price_header' => 'Price',
    'unit_price_header' => 'Unit Price',
    'total_price_header' => 'Total Price',
    'order_price_header' => 'Order Price',
    'delivery_price_header' => 'Delivery Price',
    'accepted_header' => 'Accepted',
    'ordered_by_header' => 'Ordered By',
    'producer_header' => 'Producer',
    'location_header' => 'Location',

    'tags_header' => 'Tags',
    'quantity_header' => 'Total',
    'created_header' => 'Created',
    'until_header' => 'Until',
    'character_header' => 'Character',
    'deliver_to_header' => 'Deliver To',

    'actions_header' => 'Actions',

    'total_label' => 'Total',

    'other_label' => ', +:count other',

    'repeating_badge' => 'Repeating',

    'edit_price_provider_title' => 'Edit Price Provider',
    'manufacturing_time_modifier_label' => 'Manufacturing Time Modifier',
    'reaction_time_modifier_label' => 'Reaction Time Modifier',

    'notifications_field_description' => 'Priority: :priority | :price ISK/unit | :totalPrice ISK Total | :location',
    'notification_more_items' => 'More Items',

    'error_no_price_provider' => 'No price provider configured or selected!',
    'error_minimal_profit_too_low' => 'The minimal profit can\'t be lower than :mpp%',
    'error_structure_not_found' => 'Could not find structure/station.',

    // Orders error
    'error_order_is_empty' => 'You need to add at least 1 item to the delivery',
    'error_order_not_found' => 'The order wasn\'t found',
    'error_obsolete_order' => 'Can\'t update pre-seat-5 orders due to breaking internal changes.',
    'error_price_provider_get_prices' => 'The price provider failed to fetch prices: :message',
    'error_deleted_in_progress_order' => 'You cannot delete orders that people are currently manufacturing!',
    'error_order_has_uncomplete_deliveries' => 'You cannot update the price on an order with incomplete deliveries',

    // Deliveries errors
    'error_delivery_not_assignable_to_repeating_order' => 'Repeating orders can\'t have deliveries',
    'error_no_quantity_provided' => 'Quantity must be larger than 0',
    'error_delivery_is_empty' => 'A delivery cannot contain 0 items',
    'error_too_much_quantity_provided' => 'Quantity must be smaller than the remaining quantity',
    'error_delivery_not_found' => 'Could not find delivery',
    'error_item_order_id_does_not_match' => 'An item provided does not match the selected order !',
    'error_delivery_item_not_found' => 'The item does not exists.',
    'error_not_allowed_to_create_delivery' => 'You are not allowed to deliver for this order.',

    'statistics' => [
        'completed_orders' => 'Completed Orders',
        'mean_order_completion_time' => 'Mean Order Completion Time',
        'completed_deliveries' => 'Completed Deliveries',
        'mean_delivery_completion_time' => 'Mean Delivery Completion Time',
    ],
];
