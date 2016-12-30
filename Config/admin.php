<?php

return [

    /*
     * These will be loaded on /{backend}/config/services
     */
    'services_views' => [
        'admin::admin.config.partials.google',
    ],

    'permission_manage' => [
        'admin_config',
        'admin_modules',
        'admin_nav',
        'admin_dashboard',
    ],

    /*
     * These will be loaded on /{backend}/config/cache
     */
    'cache_keys' => [

    ],

];
