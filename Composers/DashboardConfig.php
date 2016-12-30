<?php

namespace Cms\Modules\Admin\Composers;

use Cms\Modules\Admin\Services\ConfigService;

class DashboardConfig
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function listWidgets($view)
    {
        $widgets = $this->configService->getConfigVals('widgets.dashboard');

        if (!count($widgets)) {
            $view->with('widgets', []);

            return;
        }

        $widgets = collect($widgets)->values()->collapse()->mapWithKeys(function ($item) {
            return [$item => $item];
        });

        $view->with('widgets', $widgets);
    }
}
