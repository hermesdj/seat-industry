<?php

return [
    'menu_title' => 'Industrie',
    'menu_orders' => 'Commandes',
    'menu_deliveries' => 'Livraisons',
    'menu_settings' => 'Paramètres',
    'menu_about' => 'À propos',
    'menu_create_order' => 'Nouvelle Commande',

    'cancel' => 'Annuler',
    'back' => 'Retour',

    'price_provider_label' => 'Fournisseur de prix',
    'price_provider_hint' => 'La source des prix utilisée pour calculer le prix de la commande.',
    'price_provider_create_success' => 'Fournisseur de prix créé avec succès.',

    'amount_header' => 'Quantité',
    'completion_header' => 'Complété',
    'price_header' => 'Prix',
    'unit_price_header' => 'Prix unitaire',
    'order_price_header' => 'Prix Commande',
    'delivery_price_header' => 'Prix Livraison',
    'total_price_header' => 'Prix total',
    'accepted_header' => 'Accepté',
    'ordered_by_header' => 'Commandé par',
    'producer_header' => 'Fabricant',
    'location_header' => 'Emplacement',

    'tags_header' => 'Tags',
    'quantity_header' => 'Total',
    'created_header' => 'Créé',
    'until_header' => 'Jusqu\'à',
    'character_header' => 'Commandé par',
    'deliver_to_header' => 'Livrer à',
    'delivered_by_header' => 'Livré par',

    'actions_header' => 'Actions',

    'total_label' => 'Total',

    'other_label' => ', +:count autre',

    'repeating_badge' => 'Répéter',

    'edit_price_provider_title' => 'Modifier le fournisseur de prix',
    'manufacturing_time_modifier_label' => 'Modificateur de temps de fabrication',
    'reaction_time_modifier_label' => 'Modificateur de temps de réaction',

    'notifications_field_description' => 'Priorité: :priorité | :prix ISK/unité | :Prixtotal ISK Total | :emplacement',
    'notification_more_items' => 'Plus d\'Articles',

    'error_no_price_provider' => 'Aucun fournisseur de prix configuré ou sélectionné!',
    'error_minimal_profit_too_low' => 'Le profit minimal ne peut être inférieur à :mpp%',
    'error_structure_not_found' => 'Impossible de trouver la structure/station.',

    // Orders error
    'error_order_is_empty' => 'Vous devez ajouter au moins 1 article à la livraison',
    'error_order_not_found' => 'La commande n\'a pas été trouvée',
    'error_obsolete_order' => 'Ne peut pas modifier des commandes obsolètes d\'avant Seat 5.0 à cause d\'un changement interne du code.',
    'error_price_provider_get_prices' => 'Le fournisseur de prix n\'a pas réussi à récupérer les prix: :message',
    'error_deleted_in_progress_order' => 'Vous ne pouvez pas supprimer les commandes que des personnes sont en train de fabriquer !',
    'error_order_has_uncomplete_deliveries' => 'Vous ne pouvez pas modifier le prix d\'une commande qui a des livraisons en attente !',

    // Deliveries errors
    'error_delivery_not_assignable_to_repeating_order' => 'Les commandes répétées ne peuvent pas être livrées',
    'error_no_quantity_provided' => 'La quantité doit être supérieure à.0',
    'error_delivery_is_empty' => 'Une livraison doit contenir des lignes de quantité > 0',
    'error_too_much_quantity_provided' => 'La quantité doit être inférieure à la quantité restante',
    'error_delivery_not_found' => 'Impossible de trouver la livraison',
    'error_item_order_id_does_not_match' => 'Une ligne fournie en paramètre ne correspond pas à la bonne commande !',
    'error_delivery_item_not_found' => 'La Ligne de livraison n\'existe pas',
    'error_not_allowed_to_create_delivery' => 'Vous n\'êtes pas autorisé à livrer pour cette commande.',

    'statistics' => [
        'completed_orders' => 'Commandes Terminées',
        'mean_order_completion_time' => 'Temps Moyen Commande',
        'completed_deliveries' => 'Livraisons Terminées',
        'mean_delivery_completion_time' => 'Temps Moyen Livraison'
    ]
];