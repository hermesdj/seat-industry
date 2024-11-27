<?php

return [
    'ravworks' => [
        'description' => 'Cette section vous permet de copier/coller les données essentielles pour utiliser <a href="https://www.ravworks.com/planner" target="_blank">ravworks</a>',
        'produce' => 'Production',
        'stocks' => 'Stocks',
        'copyToClipboard' => 'Copier dans le presse papier au format Ravworks',
        'errors' => [
            'noProduction' => 'Les Lignes de la commande n\'ont pas pu être converties au format Ravworks.',
            'noPersonalStock' => "SeAT n'a pas pu récupérer les stocks de <b>:code</b> dans un conteneur personnel en jeu",
            'noCorporationStock' => "SeAT n'a pas pu récupérer les stocks de <b>:code</b> dans un conteneur corporation en jeu",
        ],
        'stockTipText' => 'Comment récupérer les stocks',
        'stockTipTitle' => 'Stocks de Commande',
        'stockTip' => 'Pour que la synchronisation du stock fonctionne, vous devez en jeu avoir un conteneur dans un hangar personnel/de corporation avec le code de commande <b>:code</b> dans le nom. <br /><br /> Ensuite vous devez clicker sur le bouton <b>Synchro Stocks</b> et attendre quelques minutes que SeAT mette à jour les données. <br /><br />Vous devez ensuite rafraîchir la page ravworks de la commande.',
    ],
    'stocks' => [
        'updateStocksBtn' => 'Synchro Stocks',
    ],
    'messages' => [
        'stocksUpdateStarted' => 'La tâche mettant à jours vos stocks a été lancée, veuillez rafraîchir la page dans une ou deux minutes.',
    ],
    'buildPlan' => [
        'in_construction' => [
            'title' => 'Fonctionalitée Prévue',
            'desc' => "Cette fonctionalité est prévue pour une future mise à jour ! L'objectif est d'intégrer une décomposition complète de ce qui est nécessaire pour fabriquer une commande et/ou une livraison et lier le tout aux stocks, compétences et disponibilité des blueprints",
        ],
        'fields' => [
            'nbContainers' => 'Conteneurs Détectés',
            'nbCorpContainers' => 'Conteneurs Corpo Détectés',
        ],
    ],
    'modals' => [
        'containers' => [
            'title' => 'Conteneurs',
        ],
    ],
];
