<?php

// if the request matches the admin route group, or we are in console(easier to debug), add the routes
// if (Request::is(\Config::get('core::routes.paths.admin').'/*') || App::runningInConsole()) {

    Route::group(array('prefix' => \Config::get('core::routes.paths.admin')), function () {
        $namespace = 'Cysha\Modules\Admin\Controllers';

        // the admin authentication routes
        Route::get('login', array('as' => 'pxcms.admin.login', 'uses' => $namespace.'\AuthController@getLogin'));
        Route::post('login', $namespace.'\AuthController@postLogin');
        Route::get('logout', array('as' => 'pxcms.admin.logout', 'uses' => $namespace.'\AuthController@getLogout'));

        // show me the dashboard!
        Route::get('dashboard', array('as' => 'pxcms.admin.index', 'uses' => $namespace.'\Admin\DashboardController@getIndex'));

        // i said, the dashboard!
        Route::get('/', function () {
            return Redirect::route('pxcms.admin.index');
        });

    });

// }
