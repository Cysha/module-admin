<?php namespace Cysha\Modules\Admin;

use Illuminate\Foundation\AliasLoader;
use Cysha\Modules\Core\BaseServiceProvider;
use Cysha\Modules\Admin\Commands\InstallCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerInstallCommand();
        $this->registerOtherPackages();
    }

    private function registerInstallCommand()
    {
        $this->app['cms.modules.admin:install'] = $this->app->share(function () {
            return new InstallCommand($this->app);
        });
        $this->commands('cms.modules.admin:install');
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
