<?php

// URI: /{backend}/config
Route::group(['prefix' => 'config', 'namespace' => 'Config'], function () {

    // URI: /{backend}/config/theme/
    Route::group(['prefix' => 'theme'], function () {
        Route::get('switch/{theme}', ['as' => 'admin.theme.switch', 'uses' => 'ThemeController@getSwitch']);
        Route::get('/', ['as' => 'admin.theme.index', 'uses' => 'ThemeController@getIndex']);
    });

    Route::post('save', ['as' => 'admin.config.store', 'uses' => 'SiteController@postStoreConfig']);
    Route::get('/', ['as' => 'admin.config.index', 'uses' => 'SiteController@getIndex']);
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
