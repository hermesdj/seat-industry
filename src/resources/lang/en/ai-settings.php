<?php

return [
    'settings_title' => 'Settings',

    'price_settings_title' => 'Price Settings',

    'default_price_provider_label' => 'Default Price Provider',
    'default_price_provider_hint' => 'The default price provider for orders. Manage price providers in the <a href=":route">price provider settings</a>.',

    'mmpp_label' => 'Minimum Profit Percentage',
    'mmpp_hint' => 'To incentive production, the plugin applies this % of the item value on top of the price. While creating an order, you can always choose to give a higher profit, but to avoid players ripping off others, they can\'t go below this value . ',

    'allow_manual_prices_label' => 'Allow manual prices below automatic prices',
    'allow_manual_prices_hint' => 'To avoid scam orders, manual prices are ignored if they are for less than the automatic price.',

    'allow_changing_price_provider_label' => 'Allows users to change the price provider when creating orders',
    'allow_changing_price_provider_hint' => 'To avoid scam orders, it is recommended to leave this option disabled.',

    'general_settings_title' => 'General Settings',

    'remove_expired_deliveries_label' => 'Remove expired deliveries',
    'remove_expired_deliveries_hint' => 'If a delivery isn\'t fulfilled when the order expires, the delivery will be deleted.',

    'default_location_label' => 'Default Location',
    'default_location_hint' => 'Controls the preselected location when creating new orders',

    'notifications_ping_role_label' => 'Notifications: Roles to ping on order creation',
    'notifications_ping_role_hint' => 'Please copy&paste the discord role ids separated by a space. If you enable developer mode in your settings, you can get the IDs by clicking the role.',

    'update_settings_btn' => 'Update Settings',
    'update_settings_success' => 'Successfully saved settings',

    'price_provider_whitelist_label' => 'Price Provider Whitelist',
    'price_provider_whitelist_hint' => 'The selected price providers can be used by users who have the correct permissions.'
];