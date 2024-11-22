<?php

use Seat\HermesDj\Industry\PriceProvider\BuildTimePriceProvider;

return [
    'hermesdj/seat-industry/build-time' => [
        'backend' => BuildTimePriceProvider::class,
        'label' => 'seat-industry::ai-config.build_time_price_provider',
        'plugin' => 'hermesdj/seat-industry',
        'settings_route' => 'industry.priceprovider.buildtime.configuration',
    ],
];
