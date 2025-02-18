<?php

return [
    'permissions' => [
        'manage_public_profile' => [
            'label' => 'Manage Public Profile',
            'description' => 'Allow the user to manage public industry profiles that can be used and copied by anyone'
        ],
        'manage_corporation_profile' => [
            'label' => 'Manage Corporation Profile',
            'description' => 'Allow the user to manage corporation industry profiles that can be used and copied by corp members'
        ],
        'manage_alliance_profile' => [
            'label' => 'Manage Alliance Profile',
            'description' => 'Allow the user to manage alliance industry profiles that can be used and copied by alliance members'
        ],
    ],
    'home' => [
        'title' => 'Industry Profiles'
    ],
    'list' => [
        'title' => 'Profile List',
        'empty' => 'No :list found',
        'titles' => [
            'public_profiles' => 'Public Profiles',
            'alliance_profiles' => 'Alliance Profiles',
            'corporation_profiles' => 'Corporation Profiles',
            'personal_profiles' => 'Personal Profiles',
        ]
    ],
    'btns' => [
        'create' => 'New Profile'
    ],
    'modals' => [
        'createProfile' => [
            'title' => 'Create new industry profile',
            'desc' => 'This will create a new industry profile that can be used to generate a detailed build plan for an industry order or delivery'
        ]
    ],
    'fields' => [
        'name' => 'Name',
        'scope' => 'Scope'
    ],
    'scopes' => [
        'public' => 'Public',
        'alliance' => 'Alliance',
        'corporation' => 'Corporation',
        'personal' => 'Personal'
    ],
    'messages' => [
        'create_profile_success' => 'Profile created successfully'
    ]
];