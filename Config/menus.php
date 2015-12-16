<?php

return [

    'backend_sidebar' => [
        'System' => [
            'children' => [
                [
                    'route'         => 'admin.config.website',
                    'text'          => 'Configuration',
                    'icon'          => 'fa-wrench',
                    'order'         => 1,
                    'permission'    => 'manage@admin_config',
                    'activePattern' => '\/{backend}\/config\/*',
                ],
                [
                    'route'      => 'admin.config.theme',
                    'text'       => 'Theme Manager',
                    'icon'       => 'fa-image',
                    'order'      => 2,
                    'permission' => 'theme@admin_config',
                ],
                [
                   'route'      => 'admin.modules.manager',
                   'text'       => 'Module Manager',
                   'icon'       => 'fa-puzzle-piece',
                   'order'      => 3,
                   'permission' => 'manage@admin_modules',
                ],
            ],
        ],
    ],

    'backend_config_menu' => [
        [
            'route'      => 'admin.config.website',
            'text'       => 'Website Configuration',
            'icon'       => 'fa-wrench',
            'order'      => 1,
            'permission' => 'website@admin_config',
        ],
        [
            'route'      => 'admin.config.services',
            'text'       => 'Services',
            'icon'       => 'fa-key',
            'order'      => 2,
            'permission' => 'services@admin_config',
        ],
        [
            'route'      => 'admin.config.routes',
            'text'       => 'Base Routes',
            'icon'       => 'fa-sitemap',
            'order'      => 3,
            'permission' => 'routes@admin_config',
        ],
        [
            'route'      => 'admin.config.cache',
            'text'       => 'Cache',
            'icon'       => 'fa-recycle',
            'order'      => 4,
            'permission' => 'cache@admin_config',
        ],
        [
            'route'      => 'admin.config.debug',
            'text'       => 'Debug / Maintenance',
            'icon'       => 'fa-cogs',
            'order'      => 5,
            'permission' => 'debug@admin_config',
        ],
    ],

];
