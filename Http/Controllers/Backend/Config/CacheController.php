<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class CacheController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Cache Configuration');
        $this->theme->breadcrumb()->add('Cache Configuration', route('admin.config.cache'));

        return $this->setView('admin.config.cache', [

        ], 'module');
    }
}
