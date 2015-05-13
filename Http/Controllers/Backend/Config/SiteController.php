<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

class SiteController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Configuration Manager');
        $this->theme->breadcrumb()->add('Site Config', route('admin.config.index'));

        return $this->setView('admin.config.index', [
            'indexRoutes' => $this->getIndexRoutes(),
        ], 'module');
    }

    private function getIndexRoutes()
    {
        // grab a list of all the index routes
        $indexRoutes = [];

        // grab the module list
        $modules = app('modules');
        if (!count($modules->enabled())) {
            return $indexRoutes;
        }

        foreach ($modules as $module) {
            // make sure the module is enabled
            if (!$module->enabled()) {
                continue;
            }

            // test for the pre-defined config string
            $configStr = spirntf('cms.%s.config.pxcms-index', $module->getName());
            if (!Config::has($configStr)) {
                continue;
            }

            // grab the var
            $configVar = config($configStr);

            // add it to an array if not already
            if (!is_array($configVar)) {
                $configVar = [$configVar];
            }

            foreach ($configVar as $route => $name) {
                // if route is numeric, means we dont have a human readable name
                if (is_numeric($route)) {
                    $route = $name;
                    $name = 'Homepage Route';
                }

                // add this route to the array to pass back
                $indexRoutes = array_merge($indexRoutes, [$route => '['.$module->name().'] '.$name]);
            }
        }

        return $indexRoutes;
    }
}
