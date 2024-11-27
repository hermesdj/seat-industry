<?php
return [
    'ravworks' => [
        'description' => 'This section allows you to copy/paste information data required on <a href="https://www.ravworks.com/planner" target="_blank">ravworks</a>',
        'produce' => 'Produce',
        'stocks' => 'Stocks',
        'copyToClipboard' => 'Copy to clipboard in ravworks format',
        'errors' => [
            'noProduction' => 'The order items could not be converted to ravworks compatible format.',
            'noPersonalStock' => 'SeAT could not resolve the stocks for the Order <b>:code</b> personal container in game.',
            'noCorporationStock' => 'SeAT could not resolve the stocks for the Order <b>:code</b> corporation container in game.'
        ],
        'stockTipText' => 'How to retrieve the stocks',
        'stockTipTitle' => 'Order Stock Tip',
        'stockTip' => 'For the stocks to work, you need to have in game a container in a Personal/Corporation hangar with the order code <b>:code</b> in the name.<br /><br />Then you have to click the <b>Update Stocks</b> button and wait for a few minutes for SeAT to synchronize the data.<br /><br />Once the data is synced, you need to refresh the order ravworks page.'
    ],
    'stocks' => [
        'updateStocksBtn' => 'Update Stocks'
    ],
    'messages' => [
        'stocksUpdateStarted' => 'The Job to update the stocks for this order has been started. You can refresh this page in a minute or two.'
    ],
    'buildPlan' => [
        'in_construction' => [
            'title' => 'Feature Planned',
            'text' => 'This feature is planned for the next versions ! The goal is to have a full breakdown of the industry required to produce an order and/or a delivery, and link with current stocks, skills and blueprint availability.'
        ],
        'fields' => [
            'nbContainers' => 'Detected Containers',
            'nbCorpContainers' => 'Detected Corp Containers'
        ]
    ],
    'modals' => [
        'containers' => [
            'title' => 'Containers',
            'headers' => [
                'container' => 'Container',
                'name' => 'Name',
                'location' => 'Location'
            ]
        ]
    ]
];