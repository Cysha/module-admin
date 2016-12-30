<?php

namespace Cms\Modules\Admin\Services;

use Cms\Modules\Admin\Models\Widget;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Repository as Module;
use Teepluss\Theme\Contracts\Theme;

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

    /**
     * @var Theme
     */
    protected $theme;

    public function __construct(Config $config, Module $modules, Theme $theme)
    {
        $this->config = $config;
        $this->modules = $modules;
        $this->theme = $theme;
    }

    /**
     * Figures out which modules have exposed a widgets.js file, and loads it in.
     */
    public function loadWidgetAssets()
    {
        // load the main assets up
        $this->theme->asset()->add(
            'dashboard.js',
            'modules/admin/js/dashboard.js',
            ['js']
        );
        $this->theme->asset()->add(
            'dashboard.css',
            'modules/admin/css/dashboard.css',
            ['css']
        );

        // figure out which module has exposed widgets
        $files = File::glob(public_path('modules/*/js/widgets.js'));
        $basePath = public_path();
        foreach ($files as $file) {
            $path = str_replace($basePath, '', $file);
            $moduleName = array_get(explode('/', $path), 2);

            // load them in too :D
            $this->theme->asset()->add(
                $moduleName.'_widgets',
                $path,
                ['js']
            );
        }
    }

    public function getGridLayout()
    {
        $widgets = Widget::with('options')->get();

        $widgets = $widgets->map(function ($widget) {
            $widgetBase = $widget->toArray();

            $widgetBase['options'] = collect($widget->options)
                ->mapWithKeys(function ($option) {
                    return [$option->key => $option->value];
                })->toArray();

            return $widgetBase;
        });

        return $widgets;
    }

    public function hasUpdateView($component)
    {
        // grab the module list
        if (!count($this->modules->enabled())) {
            return;
        }

        foreach ($this->modules->getOrdered() as $module) {
            // make sure the module is enabled
            if (!$module->enabled()) {
                continue;
            }

            // test for the pre-defined view
            $viewStr = sprintf('%s::admin.dashboard.widgets.%s', $module->getLowerName(), $component);
            if (view()->exists($viewStr)) {
                return $viewStr;
            }

            $viewStr = sprintf('%s::backend.dashboard.widgets.%s', $module->getLowerName(), $component);
            if (view()->exists($viewStr)) {
                return $viewStr;
            }
        }

        return;
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
            $configStr = sprintf('cms.%s.widgets.dashboard', $module->getLowerName());
            if (!$this->config->has($configStr)) {
                continue;
            }

            // grab the var
            $configVar = $this->config->get($configStr);
            if (empty($configVar)) {
                continue;
            }

            foreach ($configVar as $widget) {
                $view = array_get($widget, 'view');
                $name = array_get($widget, 'name');

                // add this route to the array to pass back
                if (!isset($widgets[$module->getStudlyName()])) {
                    $widgets[$module->getStudlyName()] = [];
                }
                $widgets[$module->getStudlyName()] = array_merge($widgets[$module->getStudlyName()], [$view => $name]);
            }
        }

        return $widgets;
    }
}
