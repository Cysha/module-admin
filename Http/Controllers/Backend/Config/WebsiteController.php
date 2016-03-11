<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

use Cms\Modules\Admin\Services\ConfigService;

class WebsiteController extends BaseConfigController
{
    public function getIndex(ConfigService $config)
    {
        $this->theme->setTitle('Website Configuration');
        $this->theme->breadcrumb()->add('Website Configuration', route('admin.config.website'));

        return $this->setView('admin.config.website', [
            'indexRoutes' => $config->getIndexRoutes(),
            'timezones' => $config->getTimezoneList(),
        ], 'module');
    }
}
