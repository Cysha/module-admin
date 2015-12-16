<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class DebugController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Debug Configuration');
        $this->theme->breadcrumb()->add('Debug Configuration', route('admin.config.debug'));

        return $this->setView('admin.config.debug', [

        ], 'module');
    }
}
