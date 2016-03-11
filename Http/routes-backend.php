<?php

use Illuminate\Routing\Router;

// URI: /{backend}/config
$router->group([
    'prefix' => 'config',
    'namespace' => 'Config',
], function (Router $router) {

    $router->get('website', ['as' => 'admin.config.website', 'uses' => 'WebsiteController@getIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'website@admin_config']);
    $router->get('theme', ['as' => 'admin.config.theme', 'uses' => 'ThemeController@getIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'theme@admin_config']);
    $router->get('services', ['as' => 'admin.config.services', 'uses' => 'ServicesController@getIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'services@admin_config']);
    $router->get('routes', ['as' => 'admin.config.routes', 'uses' => 'RoutesController@getIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'routes@admin_config']);
    $router->get('cache', ['as' => 'admin.config.cache', 'uses' => 'CacheController@getIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'cache@admin_config']);
    $router->get('debug', ['as' => 'admin.config.debug', 'uses' => 'DebugController@getIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'debug@admin_config']);

    $router->post('cache', ['uses' => 'CacheController@postIndex', 'middleware' => 'hasPermission', 'hasPermission' => 'cache@admin_config']);

    $router->post('save', ['as' => 'admin.config.store', 'uses' => 'WebsiteController@postStoreConfig']);
});

// URI: /{backend}/dashboard
$router->group([
    'prefix' => 'dashboard',
    'namespace' => 'Dashboard',
    'middleware' => 'hasPermission',
    'hasPermission' => 'access@admin_config',
], function (Router $router) {

    $router->post('saveGrid', ['as' => 'admin.dashboard.savegrid', 'uses' => 'DashboardController@saveGrid']);
    $router->post('loadWidget', ['as' => 'admin.dashboard.widget', 'uses' => 'DashboardController@loadWidget']);

    $router->get('/', ['as' => 'pxcms.admin.index', 'uses' => 'DashboardController@getIndex']);
});

// URI: /{backend}/modules
$router->group([
    'prefix' => 'modules',
    'namespace' => 'Modules',
    'middleware' => 'hasPermission',
    'hasPermission' => 'manage@admin_modules',
], function (Router $router) {

    $router->group(['prefix' => '{admin_module_name}'], function (Router $router) {
        $router->post('enable', ['as' => 'admin.modules.enable', 'uses' => 'ModuleController@postEnableModule']);
        $router->post('disable', ['as' => 'admin.modules.disable', 'uses' => 'ModuleController@postDisableModule']);

        $router->get('/', ['as' => 'admin.modules.view', 'uses' => 'ModuleController@getInfo']);
    });

    $router->post('/', ['as' => 'admin.modules.update', 'uses' => 'ModuleController@checkForUpdates']);
    $router->get('/', ['as' => 'admin.modules.manager', 'uses' => 'ModuleController@manager']);
});

$router->get('/', ['uses' => 'Dashboard\DashboardController@redirect']);
