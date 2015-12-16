<?php

namespace Cms\Modules\Admin\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AdminServicesProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // if BugSnag is installed, load it up & sort the aliasing
        if (class_exists('Bugsnag\BugsnagLaravel\BugsnagLaravelServiceProvider')) {
            \Config::set(
                'cms.admin.admin.services_views',
                array_merge(config('cms.admin.admin.services_views'), ['admin::admin.config.partials.bugsnag'])
            );

            $this->app->register('Bugsnag\BugsnagLaravel\BugsnagLaravelServiceProvider');
            AliasLoader::getInstance()->alias('Bugsnag', 'Bugsnag\BugsnagLaravel\BugsnagFacade');
        }
    }
}
