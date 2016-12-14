<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Dashboard;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends BaseAdminController
{
    public function getIndex(DashboardService $dashboard)
    {
        $this->theme->asset()->add(
            'jquery-ui.min.js',
            '//code.jquery.com/ui/1.11.2/jquery-ui.min.js',
            ['bootstrap.js']
        );
        $this->theme->asset()->add(
            'lodash.min.js',
            '//cdnjs.cloudflare.com/ajax/libs/lodash.js/3.5.0/lodash.min.js',
            ['jquery-ui.min.js']
        );
        $this->theme->asset()->add(
            'gridstack.js',
            'modules/admin/gridstack/gridstack.js',
            ['lodash.min.js']
        );
        $this->theme->asset()->add(
            'gridstack.css',
            'modules/admin/gridstack/gridstack.css',
            ['lodash.min.js']
        );

        $this->theme->setTitle('Dashboard');

        return $this->setView('admin.dashboard.index', [
            'widgetList' => $dashboard->getWidgetList(),
        ], 'module');
    }

    public function loadWidget(DashboardService $dashboard, Request $input)
    {
        $requestedWidget = $input->get('widget');

        $widgetList = [];
        foreach ($dashboard->getWidgetList() as $module => $widgets) {
            $widgetList = array_merge($widgetList, $widgets);
        }

        if (in_array($requestedWidget, array_keys($widgetList))) {
            return view($requestedWidget);
        }

        return 'Error: Can\'t load '.$requestedWidget.'';
    }

    public function saveGrid(Request $input)
    {
        $grid = $input->get('grid');
        if (empty($grid)) {
            return 'false';
        }

        $save = save_config_var('cms.admin.dashboard.grid', $grid);

        return $save ? 'true' : 'false';
    }

    public function redirect()
    {
        return redirect(route('pxcms.admin.index'));
    }
}
