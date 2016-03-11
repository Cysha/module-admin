<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class ThemeController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Theme Manager');
        $this->theme->breadcrumb()->add('Theme Manager', route('admin.config.theme'));

        return $this->setView('admin.config.theme', [

        ], 'module');
    }
}
