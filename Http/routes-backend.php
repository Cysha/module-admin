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

// URI: /{backend}/navigation
$router->group([
    'prefix' => 'navigation',
    'namespace' => 'Navigation',
    'middleware' => 'hasPermission',
    'hasPermission' => 'manage@admin_nav',
], function (Router $router) {

    $router->post('create', ['uses' => 'NavController@store']);
    $router->get('create', ['as' => 'admin.nav.create', 'uses' => 'NavController@create']);

    $router->group(['prefix' => '{admin_nav_name}'], function (Router $router) {
        $router->post('new-link', ['uses' => 'NavLinksController@store']);
        $router->get('new-link', ['as' => 'admin.nav.links.create', 'uses' => 'NavLinksController@create']);

        $router->group(['prefix' => 'link/{admin_link_id}'], function (Router $router) {
            $router->post('up', ['as' => 'admin.nav.links.move-up', 'uses' => 'NavLinksController@postUp']);
            $router->post('down', ['as' => 'admin.nav.links.move-down', 'uses' => 'NavLinksController@postDown']);

            $router->post('/', ['uses' => 'NavLinksController@store']);
            $router->get('/', ['as' => 'admin.nav.links.update', 'uses' => 'NavLinksController@update']);
        });

        $router->post('/', ['uses' => 'NavController@store']);
        $router->get('/', ['as' => 'admin.nav.update', 'uses' => 'NavController@update']);
    });

    $router->get('/', ['as' => 'admin.nav.manager', 'uses' => 'NavController@manager']);
});

$router->get('/', ['uses' => 'Dashboard\DashboardController@redirect']);
