<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

use Config;
use DateTime;
use DateTimeZone;

class SiteController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Configuration Manager');
        $this->theme->breadcrumb()->add('Site Config', route('admin.config.index'));

        return $this->setView('admin.config.index', [
            'indexRoutes' => $this->getIndexRoutes(),
            'timezones'   => $this->getTimezones(),
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

    private function getTimezones()
    {
        $zones = timezone_identifiers_list();
        $locations = [];

        foreach ($zones as $zone) {
            $zoneExploded = explode('/', $zone); // 0 => Continent, 1 => City

            // Only use "friendly" continent names
            if ($zoneExploded[0] == 'Africa' || $zoneExploded[0] == 'America' || $zoneExploded[0] == 'Antarctica' || $zoneExploded[0] == 'Arctic' || $zoneExploded[0] == 'Asia' || $zoneExploded[0] == 'Atlantic' || $zoneExploded[0] == 'Australia' || $zoneExploded[0] == 'Europe' || $zoneExploded[0] == 'Indian' || $zoneExploded[0] == 'Pacific') {
                if (isset($zoneExploded[1]) != '') {
                    $area = str_replace('_', ' ', $zoneExploded[1]);

                    if (!empty($zoneExploded[2])) {
                        $area = $area . ' (' . str_replace('_', ' ', $zoneExploded[2]) . ')';
                    }

                    $offset = (new DateTime("now", new DateTimeZone($zone)))->getOffset();
                    $locations[$zoneExploded[0]][$zone] = sprintf('UTC%s%s %s',
                        ($offset < 0 ? '-' : '+'),
                        gmdate('H:i', abs($offset)),
                        $area
                    );
                }
            }
        }

        return $locations;
    }
}
