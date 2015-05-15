<?php

return [

    'acp_menu' => [
        'System' => [
            [
                'route'      => 'admin.config.website',
                'text'       => 'Configuration',
                'icon'       => 'fa-wrench',
                //'permission' => 'website@admin_config'
            ],
        ],
    ],

    'config_menu' => [
        [
            'route'      => 'admin.config.website',
            'text'       => 'Website Configuration',
            'icon'       => 'fa-wrench',
            //'permission' => 'website@admin_config'
        ],
        [
            'route'      => 'admin.config.theme',
            'text'       => 'Theme Manager',
            'icon'       => 'fa-image',
            //'permission' => 'theme@admin_config'
        ],
        [
            'route'      => 'admin.config.services',
            'text'       => 'API Keys',
            'icon'       => 'fa-sitemap',
            //'permission' => 'services@admin_config'
        ],
        [
            'route'      => 'admin.config.cache',
            'text'       => 'Cache',
            'icon'       => 'fa-cogs',
            //'permission' => 'cache@admin_config'
        ],
        [
            'route'      => 'admin.config.debug',
            'text'       => 'Debug / Maintenance',
            'icon'       => 'fa-cogs',
            //'permission' => 'debug@admin_config'
        ],
    ],
];
