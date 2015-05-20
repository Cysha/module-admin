<?php

return [

    'acp_menu' => [
        'System' => [
            [
                'route'      => 'admin.config.website',
                'text'       => 'Configuration',
                'icon'       => 'fa-wrench',
                'permission' => 'manage@admin_config'
            ],
            [
                'route'      => 'admin.config.theme',
                'text'       => 'Theme Manager',
                'icon'       => 'fa-image',
                'permission' => 'theme@admin_config'
            ],
            //[
            //    'route'      => 'admin.module.manager',
            //    'text'       => 'Module Manager',
            //    'icon'       => 'fa-puzzle-piece',
            //    'permission' => 'manage@admin_modules'
            //],
        ],
    ],

    'config_menu' => [
        [
            'route'      => 'admin.config.website',
            'text'       => 'Website Configuration',
            'icon'       => 'fa-wrench',
            'permission' => 'website@admin_config'
        ],
        [
            'route'      => 'admin.config.services',
            'text'       => 'API Keys',
            'icon'       => 'fa-key',
            'permission' => 'services@admin_config'
        ],
        [
            'route'      => 'admin.config.routes',
            'text'       => 'Base Routes',
            'icon'       => 'fa-sitemap',
            'permission' => 'routes@admin_config'
        ],
        [
            'route'      => 'admin.config.cache',
            'text'       => 'Cache',
            'icon'       => 'fa-recycle',
            'permission' => 'cache@admin_config'
        ],
        [
            'route'      => 'admin.config.debug',
            'text'       => 'Debug / Maintenance',
            'icon'       => 'fa-cogs',
            'permission' => 'debug@admin_config'
        ],
    ],

    /**
     * These will be loaded on /{backend}/config/services
     */
    'apikey_views' => [
        'admin::admin.config.keys.ganalytics',
    ],
];
