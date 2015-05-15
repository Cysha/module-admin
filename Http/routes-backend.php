<?php

// URI: /{backend}/config
Route::group(['prefix' => 'config', 'namespace' => 'Config'], function () {

    Route::get('website', ['as' => 'admin.config.website', 'uses' => 'WebsiteController@getIndex']);
    Route::get('theme', ['as' => 'admin.config.theme', 'uses' => 'ThemeController@getIndex']);
    Route::get('services', ['as' => 'admin.config.services', 'uses' => 'ServicesController@getIndex']);
    Route::get('cache', ['as' => 'admin.config.cache', 'uses' => 'CacheController@getIndex']);
    Route::get('debug', ['as' => 'admin.config.debug', 'uses' => 'DebugController@getIndex']);

    Route::post('save', ['as' => 'admin.config.store', 'uses' => 'WebsiteController@postStoreConfig']);
    Route::get('/', function () {
        return Redirect::route('pxcms.admin.index');
    });
});

// URI: /{backend}/dashboard
Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function () {
    Route::post('saveGrid', ['as' => 'admin.dashboard.savegrid', 'uses' => 'DashboardController@saveGrid']);
    Route::post('loadWidget', ['as' => 'admin.dashboard.widget', 'uses' => 'DashboardController@loadWidget']);

    Route::get('/', ['as' => 'pxcms.admin.index', 'uses' => 'DashboardController@getIndex']);
});

// the admin authentication routes
Route::get('login', ['as' => 'pxcms.admin.login', 'uses' => 'AuthController@getLogin']);
Route::post('login', 'AuthController@postLogin');
Route::get('logout', ['as' => 'pxcms.admin.logout', 'uses' => 'AuthController@getLogout']);

// i said, the dashboard!
Route::get('/', function () {
    return Redirect::route('pxcms.admin.index');
});
