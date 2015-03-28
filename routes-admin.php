<?php

Route::group(['prefix' => \Config::get('core::routes.paths.admin'), 'namespace' => 'Cysha\Modules\Admin\Controllers'], function () {

    // the admin authentication routes
    Route::get('login', ['as' => 'pxcms.admin.login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', ['as' => 'pxcms.admin.logout', 'uses' => 'AuthController@getLogout']);

    // show me the dashboard!
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin'], function () {
        Route::post('savegrid', ['as' => 'admin.dashboard.savegrid', 'uses' => 'DashboardController@saveGrid']);
        Route::post('loadWidget', ['as' => 'admin.dashboard.widget', 'uses' => 'DashboardController@loadWidget']);

        Route::get('/', ['as' => 'pxcms.admin.index', 'uses' => 'DashboardController@getIndex']);
    });

    // i said, the dashboard!
    Route::get('/', function () {
        return Redirect::route('pxcms.admin.index');
    });

});
