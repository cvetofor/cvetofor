<?php

return [
    'enabled' => [
        'users-management' => true,
        'media-library' => true,
        'file-library' => true,
        'block-editor' => true,
        'buckets' => true,
        'users-image' => false,
        'settings' => true,
        'dashboard' => true,
        'search' => true,
        'users-description' => false,
        'activitylog' => true,
        'users-2fa' => true,
        'users-oauth' => false,
        'permissions-management' => true,
    ],
    'file_library' => [
        'allowed_extensions' => ['mp4', 'webm', 'ogg', 'quicktime'],
    ],

    'auth_login_redirect_path' => '/hub',
    'locale' => 'ru',
    'fallback_locale' => 'ru',
    'migrations_use_big_integers' => true,
    'publish_date_24h' => true,
    // enable 24h format in publisher dates
    'publish_date_format' => 'd F Y H:i',
    // format used by publication date pickers
    'publish_date_display_format' => 'DD MMMM YYYY HH:mm',
    // format used when displaying the publication date,

    'permissions' => [
        'level' => \A17\Twill\Enums\PermissionLevel::LEVEL_ROLE,
        'modules' => [
            'orders',
            'balances',
            'deliveries',
            'markets',
            'marketWorkTimes',
            'products',
            'groupProducts',
            // 'forHer',
            'productPrices',
            'remains',
            'cities',
            'colors',
            'categories',
            'groupProductCategories',
            'deliveryStatuses',
            'orderStatuses',
            'paymentStatuses',
            // 'stocks',  # - dont uses until

            'attributes',
            'profiles',
            'forms',
            'hollydays',
            'legalAccounts',
            // 'orderItems', # - dont uses
            'pages',
            'payments',
            // 'paymentDetails',  # - dont uses
            'regions',
            'reviews',
            'tags',
            'seotags',
        ],
        // Add all modules for which permissions should apply
    ],

    'block_editor' => [
        'repeaters' => [],
        'blocks' => [],
        'crops' => [
            'director' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => null,
                    ],
                ],
            ],
            'accountant' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => null,
                    ],
                ],
            ],
            'stamp' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => null,
                    ],
                ],
            ],
            'image' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => null,
                    ],
                ],
                'desktop' => [
                    [
                        'name' => 'default',
                        'ratio' => null,
                    ],
                ],
            ],
            'files' => [
                'preview',
            ],
        ],
    ],
    'blocks_table' => 'blocks',
    'features_table' => 'features',
    'settings_table' => 'settings',
    'medias_table' => 'medias',
    'mediables_table' => 'mediables',
    'files_table' => 'files',
    'fileables_table' => 'fileables',
    'related_table' => 'related',
    'tags_table' => 'tags',
    'seotags_table' => 'seotags',
    'tagged_table' => 'tagged',
    // 'media_library' => [
    //     'extra_metadatas_fields' => [
    //         [

    //             'name' => 'user_id',
    //             'label' => 'User ID',
    //         ],
    //     ],
    // ],

    'dashboard' => [
        'modules' => [
            'groupProducts' => [
                'name' => 'groupProducts',
                'label' => 'Ваши букеты',
                'routePrefix' => '',
                'count' => true,
                'create' => true,
                'activity' => false,
                'draft' => true,
                'search' => true,
                'search_fields' => ['title'],
            ],
            'forHer' => [
                'name' => 'forHer',
                'label' => 'Ваши букеты',
                'routePrefix' => '',
                'count' => true,
                'create' => true,
                'activity' => false,
                'draft' => true,
                'search' => true,
                'search_fields' => ['title'],
            ],
            'products' => [
                'name' => 'products',
                'label' => 'Товары',
                'routePrefix' => '',
                'count' => true,
                'create' => true,
                'activity' => true,
                'draft' => true,
                'search' => true,
                'search_fields' => ['title'],
            ],
            'productPrices' => [
                'name' => 'productPrices',
                'label' => 'Товары',
                'routePrefix' => '',
                'count' => true,
                'create' => true,
                'activity' => true,
                'draft' => true,
                'search' => true,
                'search_fields' => ['sku'],
            ],
        ],
    ],
];
