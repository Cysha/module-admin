<?php

use Illuminate\Routing\Router;

// URI: /{backend}/config
$router->group(['prefix' => 'config', 'namespace' => 'Config'], function (Router $router) {

    $router->get('website', ['as' => 'admin.config.website', 'uses' => 'WebsiteController@getIndex']);
    $router->get('theme', ['as' => 'admin.config.theme', 'uses' => 'ThemeController@getIndex']);
    $router->get('services', ['as' => 'admin.config.services', 'uses' => 'ServicesController@getIndex']);
    $router->get('routes', ['as' => 'admin.config.routes', 'uses' => 'RoutesController@getIndex']);
    $router->get('cache', ['as' => 'admin.config.cache', 'uses' => 'CacheController@getIndex']);
    $router->get('debug', ['as' => 'admin.config.debug', 'uses' => 'DebugController@getIndex']);

    $router->post('save', ['as' => 'admin.config.store', 'uses' => 'WebsiteController@postStoreConfig']);
    $router->get('/', function () {
        return Redirect::route('pxcms.admin.index');
    });
});

// URI: /{backend}/dashboard
$router->group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function (Router $router) {
    $router->post('saveGrid', ['as' => 'admin.dashboard.savegrid', 'uses' => 'DashboardController@saveGrid']);
    $router->post('loadWidget', ['as' => 'admin.dashboard.widget', 'uses' => 'DashboardController@loadWidget']);

    $router->get('/', ['as' => 'pxcms.admin.index', 'uses' => 'DashboardController@getIndex']);
});

// the admin authentication routes
$router->get('login', ['as' => 'pxcms.admin.login', 'uses' => 'AuthController@getLogin']);
$router->post('login', 'AuthController@postLogin');
$router->get('logout', ['as' => 'pxcms.admin.logout', 'uses' => 'AuthController@getLogout']);

// i said, the dashboard!
$router->get('/', function () {
    return Redirect::route('pxcms.admin.index');
});
