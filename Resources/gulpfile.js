var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
        .sass('./dashboard/sass/app.scss', 'assets/css/dashboard.css')
        .webpack('./dashboard/js/dashboard.js', 'assets/js/dashboard.js')
        .exec('php ../../../../artisan module:publish Admin', '**/*.js');

    mix.webpack('./dashboard/widgets.js', 'assets/js/widgets.js')
        .exec('php ../../../../artisan module:publish Admin', '**/*.vue');
});
