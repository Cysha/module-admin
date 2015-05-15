<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class ServicesController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('API Keys Configuration');
        $this->theme->breadcrumb()->add('API Keys Configuration', route('admin.config.services'));

        return $this->setView('admin.config.services', [

        ], 'module');
    }
}
