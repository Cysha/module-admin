<?php namespace Cms\Modules\Admin\Providers;

use Cms\Modules\Core\Providers\CmsRoutingProvider;
use Illuminate\Routing\Router;

class AdminRoutingProvider extends CmsRoutingProvider
{

    protected $namespace = 'Cms\Modules\Admin\Http\Controllers';

    /**
     * @return string
     */
    protected function getFrontendRoute()
    {
        return __DIR__ . '/../Http/routes-frontend.php';
    }

    /**
     * @return string
     */
    protected function getBackendRoute()
    {
        return __DIR__ . '/../Http/routes-backend.php';
    }

    /**
     * @return string
     */
    protected function getApiRoute()
    {
        return __DIR__ . '/../Http/routes-api.php';
    }

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('admin_module_name', function ($name) {
            return \Cms\Modules\Core\Models\Module::findOrFail($name);
        });

    }
}
