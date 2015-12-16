<?php

namespace Cms\Modules\Admin\Providers;

use Cms\Modules\Core\Providers\BaseModuleProvider;

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

        $this->registerWidgets();
    }

    /**
     * Register all the widgets from the modules.
     */
    public function registerWidgets()
    {
        $config = get_array_column(config('cms'), 'widgets');
        if (!count($config)) {
            return;
        }

        foreach ($config as $module) {
            foreach (array_get($module, 'dashboard') as $widget) {
                // echo \Debug::dump($widget, '');
                view()->composer(array_get($widget, 'view'), array_get($widget, 'class'));
            }
        }
    }
}
