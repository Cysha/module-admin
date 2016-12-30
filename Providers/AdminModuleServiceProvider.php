<?php

namespace Cms\Modules\Admin\Providers;

use Cms\Modules\Core\Providers\BaseModuleProvider;
use Cms\Modules\Admin\Composers\DashboardConfig;

class AdminModuleServiceProvider extends BaseModuleProvider
{
    /**
     * Register the defined middleware.
     *
     * @var array
     */
    protected $middleware = [
        'Admin' => [
            'auth.admin' => 'AuthAdminMiddleware',
        ],
    ];

    /**
     * The commands to register.
     *
     * @var array
     */
    protected $commands = [
        'Admin' => [
            'cms:debug' => 'DebugSetCommand',
            'cms:maintenance' => 'MaintenanceSetCommand',
        ],
    ];

    /**
     * Register repository bindings to the IoC.
     *
     * @var array
     */
    protected $bindings = [

    ];

    public function boot()
    {
        parent::boot();

        view()->composer('admin::admin.config.dashboard', DashboardConfig::class.'@listWidgets');
    }
}
