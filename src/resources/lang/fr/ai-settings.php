<?php

return [
    'settings_title' => 'Paramètres',

    'price_settings_title' => 'Paramètres des prix',

    'default_price_provider_label' => 'Fournisseur de prix par défaut',
    'default_price_provider_hint' => 'Le fournisseur de prix par défaut pour les commandes. Gérer le fournisseur de prix dans <a href=":route">se trouvant dans les paramètres des prix</a>.',

    'mmpp_label' => 'Pourcentage de profit minimum',
    'mmpp_hint' => 'Pour inciter à la production, le plugin applique ce % à l\'item à son prix le plus haut. À la création d\'une commande, vous pouvez toujours choisir de donner une plus grande marge, mais pour éviter que les joueurs ne s\'arnaquent, ils ne peuvent pas descendre en-dessous de cette valeur.',

    'allow_manual_prices_label' => 'Autoriser les prix manuels à être en-dessous du prix automatique',
    'allow_manual_prices_hint' => 'Pour éviter les prix frauduleux, les prix manuels sont ignorés s`\'ils sont en-dessous du prix automatique.',

    'allow_changing_price_provider_label' => 'Autoriser les utilisateurs à changer le fournisseur de prix lors de la création d\'une commande.',
    'allow_changing_price_provider_hint' => 'Pour éviter les commandes frauduleuses, il est recommandé de laisser cette option désactivée.',

    'general_settings_title' => 'Paramètres Généraux',

    'remove_expired_deliveries_label' => 'Supprimer les livraisons expirées',
    'remove_expired_deliveries_hint' => 'Si une livraison n\'est pas complétée avant l\'expiration de la commande, la livraison est supprimée.',

    'default_location_label' => 'Localisations par défaut',
    'default_location_hint' => 'Contrôle les localisations présélectionnées lors de la création d\'une commande',

    'notifications_ping_role_label' => 'Notifications: Roles à ping lors de le création d\'une commande',
    'notifications_ping_role_hint' => 'Copier/coller les IDs des rôles Discord en laissant un espace entre chacun d\'eux. Si vous avez le mode développeur activé dans vos paramètres, il suffit de cliquer sur le rôle pour avoir son ID.',

    'update_settings_btn' => 'Mettre à jour les paramètres',
    'update_settings_success' => 'Mise à jour des paramètres effectuée.',
];