<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Dashboard;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Input;
use Config;

class DashboardController extends BaseAdminController
{
    public function getIndex()
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
            'widgetList' => $this->getWidgetList(),
        ], 'module');
    }

    public function loadWidget()
    {
        $requestedWidget = Input::get('widget');
        if (in_array($requestedWidget, array_keys($this->getWidgetList()))) {
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


    private function getWidgetList()
    {
        $widgets = [];

        // grab the module list
        $modules = app('modules');
        if (count($modules)) {
            foreach ($modules as $module) {
                // make sure the module is enabled
                if (!$module->enabled()) {
                    continue;
                }

                // test for the pre-defined config string
                $configStr = sprintf('cms.%s.admin.dashboard_widgets', $module->name());
                if (Config::has($configStr)) {
                    $configVar = config($configStr);

                    // add it to an array if not already
                    if (!is_array($configVar)) {
                        $configVar = [$configVar];
                    }

                    foreach ($configVar as $route => $name) {
                        // if route is numeric, means we dont have a human readable name
                        if (is_numeric($route)) {
                            $route = $name;
                            $name = 'Untitled Widget '.$route;
                        }

                        // add this route to the array to pass back
                        $widgets = array_merge($widgets, [$route => '['.$module->name().'] '.$name]);
                    }
                }
            }
        }

        return $widgets;
    }
}
