<?php namespace Cms\Modules\Admin\Services;

use Illuminate\Contracts\Config\Repository as Config;
use Pingpong\Modules\Repository as Module;

class DashboardService
{
    /**
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var Modules
     */
    protected $modules;

    public function __construct(Config $config, Module $modules)
    {
        $this->config = $config;
        $this->modules = $modules;
    }

    public function getWidgetList()
    {
        $widgets = [];

        // grab the module list
        if (!count($this->modules->enabled())) {
            return $widgets;
        }

        foreach ($this->modules->getOrdered() as $module) {
            // make sure the module is enabled
            if (!$module->enabled()) {
                continue;
            }

            // test for the pre-defined config string
            $configStr = sprintf('cms.%s.admin.dashboard_widgets', $module->getLowerName());
            if (!$this->config->has($configStr)) {
                continue;
            }

            // grab the var
            $configVar = $this->config->get($configStr);
            if (empty($configVar)) {
                continue;
            }

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
                $widgets = array_merge($widgets, [$route => '['.$module->getStudlyName().'] '.$name]);
            }
        }

        return $widgets;
    }
}
