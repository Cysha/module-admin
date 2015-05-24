<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Dashboard;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Services\DashboardService;
use Input;
use Config;

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
            'packages/module/admin/assets/gridstack/gridstack.js',
            ['lodash.min.js']
        );
        $this->theme->asset()->add(
            'gridstack.css',
            'packages/module/admin/assets/gridstack/gridstack.css',
            ['lodash.min.js']
        );

        $this->theme->setTitle('Dashboard');
        return $this->setView('admin.dashboard.index', [
            'widgetList' => $dashboard->getWidgetList(),
        ], 'module');
    }

    public function loadWidget(DashboardService $dashboard)
    {
        $requestedWidget = Input::get('widget');
        if (in_array($requestedWidget, array_keys($dashboard->getWidgetList()))) {
            return view($requestedWidget);
        }

        return 'Error: Can\'t load '.$requestedWidget.'';
    }

    public function saveGrid()
    {
        $grid = Input::get('grid');
        if (empty($grid)) {
            return 'false';
        }

        $save = save_config_var('admin::dashboard.grid', $grid);
        return $save ? 'true' : 'false';
    }

}
