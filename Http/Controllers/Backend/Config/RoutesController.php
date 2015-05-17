<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class RoutesController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Route Configuration');
        $this->theme->breadcrumb()->add('Route Configuration', route('admin.config.routes'));

        return $this->setView('admin.config.routes', [

        ], 'module');
    }
}
