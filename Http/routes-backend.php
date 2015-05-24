<?php

use Illuminate\Routing\Router;

// URI: /{backend}/config
$router->group([
    'prefix' => 'config',
    'namespace' => 'Config'
], function (Router $router) {

    $router->get('website', ['as' => 'admin.config.website', 'uses' => 'WebsiteController@getIndex']);
    $router->get('theme', ['as' => 'admin.config.theme', 'uses' => 'ThemeController@getIndex']);
    $router->get('services', ['as' => 'admin.config.services', 'uses' => 'ServicesController@getIndex']);
    $router->get('routes', ['as' => 'admin.config.routes', 'uses' => 'RoutesController@getIndex']);
    $router->get('cache', ['as' => 'admin.config.cache', 'uses' => 'CacheController@getIndex']);
    $router->get('debug', ['as' => 'admin.config.debug', 'uses' => 'DebugController@getIndex']);

    $router->post('save', ['as' => 'admin.config.store', 'uses' => 'WebsiteController@postStoreConfig']);
});

// URI: /{backend}/dashboard
$router->group([
    'prefix'    => 'dashboard',
    'namespace' => 'Dashboard',
], function (Router $router) {

    $router->post('saveGrid', ['as' => 'admin.dashboard.savegrid', 'uses' => 'DashboardController@saveGrid']);
    $router->post('loadWidget', ['as' => 'admin.dashboard.widget', 'uses' => 'DashboardController@loadWidget']);

    $router->get('/', ['as' => 'pxcms.admin.index', 'uses' => 'DashboardController@getIndex']);
});

// URI: /{backend}/modules
// $router->group([
//     'prefix'        => 'modules',
//     'namespace'     => 'Modules',
//     'middleware'    => ['hasPermission'],
//     'hasPermission' => 'manage@admin_modules',
// ], function (Router $router) {

//     $router->post('/', ['uses' => 'ModuleManagerController@moduleManager']);
//     $router->get('/', ['as' => 'admin.module.manager', 'uses' => 'ModuleManagerController@moduleManager']);
// });

// i said, the dashboard!
$router->get('/', ['uses' => 'Dashboard\DashboardController@redirect']);
