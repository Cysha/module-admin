<?php namespace Cms\Modules\Admin\Providers;

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
        ],
    ];

    /**
     * The commands to register.
     *
     * @var array
     */
    protected $commands = [
        'Admin' => [
        ],
    ];


}
