<?php

return [
    'create_order_title' => 'Créer une Commande',

    'order_title' => 'Commande N°:code - :reference',
    'orders_title' => 'Commandes',
    'order_reference' => 'Référence Cde',
    'your_orders_title' => 'Vos Commandes',

    'order_menu' => [
        'details' => 'Commande',
        'deliveries' => 'Livraisons',
        'ravworks' => 'Ravworks',
        'build_plan' => 'Plan de Fabrication',
    ],

    'repeating_order_title' => 'Commande répétée',
    'repeating_order_desc' => 'Ceci est une commande qui se republie elle-même chaque :days jours. La prochaine republication au lieu le :date.',

    'items_label' => 'Items',
    'items_placeholder' => "MULTIBUY:\nTristan 100\nOmen 100\nTritanium 30000\n\nFITTINGS:\n[Pacifier, 2022 Scanner]\n\nCo-Processor II\nCo-Processor II\n\nMultispectrum Shield Hardener II\nMultispectrum Shield Hardener II\n\nSmall Tractor Beam II\nSmall Tractor Beam II",

    'reward_label' => 'Profit en %',
    'reward_hint' => 'Le profit minimum est de :mpp% et sera ajouté au prix calculé automatiquement. Un profit plus élevé peut encourager les producteurs à travailler plus vite.',
    'add_profit_to_manual_prices_label' => 'Ajouter une marge au prix manuel',

    'days_to_complete_label' => 'Jours pour compléter',

    'location_label' => 'Localisation',
    'priority_label' => 'Priorité',
    'priority_Very Low' => 'Très basse',
    'priority_Low' => 'basse',
    'priority_Normal' => 'Normal',
    'priority_Preferred' => 'Priorisé',
    'priority_Important' => 'Important',
    'priority_Critical' => 'Critique',
    'time_label' => 'Délai',
    'time_hint' => 'Va ajouter le nombre de jour saisi au délai de la commande.',

    'quantity_label' => 'Quantité',
    'quantity_hint' => 'Le nombre de commandes à passer pour ce qui a été collé dans le champ. Utile pour commander plusieurs fois le même fit de vaisseau par exemple.',

    'reference_label' => 'Référence',
    'reference_hint' => 'Vous pouvez donner un nom à votre commande. Laisser ce champ vide le remplira automatiquement avec un ID généré. Si vous collez un fit dans le champ de saisie principal, et laissez ce champ vide, le nom du fit sera utilisé comme référence.',

    'seat_inventory_label' => 'Seat-Inventory',
    'seat_inventory_hint' => 'Ajouter une source à seat-inventory',
    'seat_inventory_desc' => 'Dès que la livraison pour cette commande sera créée, une source d\'objet sera ajoutée à seat-inventory. Une fois que la livraison est marquée comme terminée, la source sera retirée. La source sera ajoutée au <u>premier</u> espace de travail contenant le label <code>add2Industry</code> à n\'importe quelle position de son nom. Vous pouvez renommer les espaces de travail <a href=":route">içi</a>.',
    //'seat_inventory_desc' => 'As soon as a delivery for this order is created, a item source will be added to seat-inventory. Once the delivery is marked as completed, the source will be removed. The source will be added to the <u>first</u> workspace containing <code>add2Industry</code> at any position in it\'s name. You can rename workspaces <a href=":route">here.</a>',

    'deliver_to_label' => 'Livrer à',
    'deliver_to_hint' => 'Sélectionnez le personnage à qui la commande doit être livrée',

    'repetition_label' => 'Répétition',
    'repetition_never' => 'Jamais',
    'repetition_weekly' => 'Hebdomadaire',
    'repetition_every_two_weeks' => 'Bi-hebdomadaire',
    'repetition_monthly' => 'Mensuel',

    'no_delivery' => 'Pas de Livraison',

    'add_order_btn' => 'Ajouter une commande',

    'invalid_order_label' => 'Commande invalide',

    'empty_deliveries' => 'Il n\'y a pas encore de Livraisons pour cette commande.',

    'close_order_btn' => 'Fermer',
    'update_price_btn' => 'Mettre à jour le prix',
    'update_price_action' => 'Mettre à jour le prix ? Le prix manuel sera écrasé !',
    'extend_time_btn' => 'Ajouter du temps',
    'extend_time_action' => ' souhaite ajouter 1 semaine au temps de livraison',

    // Marketplace
    'order_marketplace_title' => 'Marché des Commandes',
    'open_orders_title' => 'Voir les commandes',

    'close_all_completed_orders_btn' => 'Fermer toutes les commandes complétées',

    'create_order_success' => 'Ajout d\'une nouvelle commande réussi !',
    'update_time_success' => 'Temps ajouté !',
    'update_price_success' => 'Prix mis à jour !',
    'close_order_success' => 'Fermeture de la commande réussi !',

    'order_id' => 'Code Commande',
    'reserve_corp_btn' => 'Reservé Corp.',
    'confirm_order_btn' => 'Confirmer',

    'list' => [
        'titles' => [
            'available' => 'Disponibles',
            'corporation' => 'Réservées Corporation',
            'my' => 'Mes Commandes',
        ],
    ],

    'status' => [
        'available' => 'Disponible',
        'unconfirmed' => 'Non Confirmé',
    ],

    'btns' => [
        'updateOrderItemStates' => 'Calcul Etat Lignes',
        'reserveCorp' => 'Reservé Corp.',
        'unReserveCorp' => 'Non Reservé Corp.',
        'deleteOrder' => 'Supprimer',
        'completeOrder' => 'Terminer',
    ],

    'items' => [
        'title' => [
            'accepted' => 'Lignes à Fabriquer',
            'rejected' => 'Lignes non Fabriquées',
        ],
        'headers' => [
            'type' => 'Objet',
            'quantity' => 'Quantité',
            'unit_price' => 'Px Unitaire',
            'total' => 'Total',
        ],
    ],

    'fields' => [
        'date' => 'Date',
        'code' => 'N° Commande',
        'location' => 'Lieu de Livraison',
        'quantities' => 'Quantités Totales',
        'corporation' => 'Reservé par',
        'reference' => 'Référence',
    ],

    'summary' => [
        'title' => 'Résumé',
        'order_total' => 'Total Commandé',
        'in_delivery' => 'En Cours de Livraison',
        'delivered' => 'Livré',
        'remaining' => 'Reste à Livrer',
        'reference' => 'Référence',
        'rejected' => 'Rejeté',
    ],

    'notifications' => [
        'new_order' => 'Nouvelle commande :code disponible !',
        'order_details' => 'Détails de la Commande :',
        'order_price' => 'Prix',
        'nb_items' => 'Nb Lignes',
        'location' => 'Lieu',
        'reference' => 'Référence',
        'expiring_order' => 'Commande :code va expirer !',
        'expiring_message' => 'Cette commande va expirer dans :remaining !',
    ],

    'modals' => [
        'editPrices' => [
            'title' => 'Modifier les prix de :code',
            'desc' => 'Cette fenêtre vous permet de recalculer le prix des éléments de la commande avec des données à jour.',
        ],
        'editTime' => [
            'title' => 'Étendre le délai de :code',
            'desc' => 'Cette fenêtre vous permet d\'ajouter des jours au délai de livraison de cette commande.',
        ],
    ],

    'messages' => [
        'order_items_state_updated' => 'Etats des lignes recalculées avec succès !',
    ],
];
