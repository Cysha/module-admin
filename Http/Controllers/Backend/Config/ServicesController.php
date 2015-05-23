<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class ServicesController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Services Configuration');
        $this->theme->breadcrumb()->add('Services Configuration', route('admin.config.services'));

        return $this->setView('admin.config.services', [

        ], 'module');
    }
}
