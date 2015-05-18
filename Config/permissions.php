<?php

return [
    'admin_config' => [
        'manage', 'website', 'theme', 'services', 'cache', 'debug', 'routes',
    ],

    'admin_modules' => [
        // backend manager
        'manage', 'manage.create', 'manage.read', 'manage.update', 'manage.delete',

        'module.install', 'module.uninstall', 'module.toggle'
    ],

];
