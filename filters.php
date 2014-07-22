<?php

Route::filter('auth.admin', function () {
    if (Auth::guest()) {
        Session::flash('info', 'You need to login');

        return Redirect::guest(URL::route('pxcms.user.login'));
    }

    if (Auth::user()->isAdmin() === false) {
        return Redirect::route('pxcms.pages.home')->withError(Lang::get('admin::admin.unauthorized'));
    }
});

// Check permissions when we start in the admin panel
Route::when(Config::get('core::routes.paths.admin').'/*', 'auth.admin');
