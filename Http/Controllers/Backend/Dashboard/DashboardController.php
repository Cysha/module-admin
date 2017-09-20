<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Dashboard;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Services\DashboardService;
use Collective\Html\HtmlBuilder;

class DashboardController extends BaseAdminController
{
    public function getIndex(DashboardService $dashboard)
    {
        $this->theme->setTitle('Dashboard');
        $dashboard->loadWidgetAssets();

        $builder = app(HtmlBuilder::class);
        $gridLayout = $dashboard->getGridLayout();

        return $this->setView('admin.dashboard.index', [
            'gridLayout' => $gridLayout,
            'builder' => $builder,
        ], 'module');
    }

    public function redirect()
    {
        return redirect(route('pxcms.admin.index'));
    }

    public function test()
    {
        return $this->setView('admin.test');
    }
}
