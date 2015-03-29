<?php namespace Cysha\Modules\Admin;

use Illuminate\Foundation\AliasLoader;
use Cysha\Modules\Core\BaseServiceProvider;
use Cysha\Modules\Admin\Commands\InstallCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerInstallCommand();
        $this->registerViewComposers();
        $this->registerOtherPackages();
    }

    private function registerInstallCommand()
    {
        $this->app['cms.modules.admin:install'] = $this->app->share(function () {
            return new InstallCommand($this->app);
        });
        $this->commands('cms.modules.admin:install');
    }

    public function registerViewComposers()
    {
        $this->app->make('view')->composer('admin::widgets.cmsUpdate', '\Cysha\Modules\Admin\Composers\Widgets@CmsUpdate');
        $this->app->make('view')->composer('admin::widgets.userCount', '\Cysha\Modules\Admin\Composers\Widgets@UserCount');
        $this->app->make('view')->composer('admin::widgets.latestUsers', '\Cysha\Modules\Admin\Composers\Widgets@LatestUsers');
        $this->app->make('view')->composer('admin::widgets.memoryUsage', '\Cysha\Modules\Admin\Composers\Widgets@MemoryUsage');
        $this->app->make('view')->composer('admin::widgets.latestUsers', '\Cysha\Modules\Admin\Composers\Widgets@LatestUsers');
    }

    private function registerOtherPackages()
    {
        $serviceProviders = [
            'Chumper\Datatable\DatatableServiceProvider',
        ];

        foreach ($serviceProviders as $sp) {
            $this->app->register($sp);
        }

        $aliases = [
            'Datatable' => 'Chumper\Datatable\Facades\DatatableFacade',
        ];

        foreach ($aliases as $alias => $class) {
            AliasLoader::getInstance()->alias($alias, $class);
        }
    }
}
