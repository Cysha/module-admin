<?php

return [

    'acp_menu' => [
        'System' => [
            [
                'route'      => 'admin.config.index',
                'text'       => 'Configuration',
                'icon'       => 'fa-wrench',
                //'permission' => 'manage@auth_user'
            ],
        ],
    ],

    'config_menu' => [
        [
            'route'      => 'admin.config.index',
            'text'       => 'Site Config',
            'icon'       => 'fa-wrench',
            //'permission' => 'manage@auth_user'
        ],
        [
            'route'      => 'admin.theme.index',
            'text'       => 'Theme Manager',
            'icon'       => 'fa-wrench',
            //'permission' => 'manage@auth_user'
        ],
    ],
];
