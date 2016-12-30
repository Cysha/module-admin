<?php

namespace Cms\Modules\Admin\Services;

use Illuminate\Contracts\Config\Repository as Config;
use Nwidart\Modules\Repository as Module;
use DateTime;
use DateTimeZone;

class ConfigService
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

    public function getConfigVals($configVal)
    {
        // grab the module list
        if (!count($this->modules->enabled())) {
            return [];
        }

        $values = [];
        foreach ($this->modules->getOrdered() as $module) {
            // make sure the module is enabled
            if (!$module->enabled()) {
                continue;
            }

            // test for the pre-defined config string
            $configStr = sprintf('cms.%s.%s', $module->getLowerName(), $configVal);
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

            $values[$module->getLowerName()] = $configVar;
        }

        return $values;
    }

    public function getIndexRoutes()
    {
        // grab a list of all the index routes
        $indexRoutes = [];

        $modules = $this->getConfigVals('config.pxcms-index');
        foreach ($modules as $moduleName => $routes) {
            foreach ($routes as $route => $name) {
                // if route is numeric, means we dont have a human readable name
                if (is_numeric($route)) {
                    $route = $name;
                    $name = 'Homepage Route';
                }

                // add this route to the array to pass back
                $indexRoutes = array_merge($indexRoutes, [
                    $route => '['.ucwords($moduleName).'] '.$name,
                ]);
            }
        }

        return $indexRoutes;
    }

    /**
     * Generates a user friendly version of the timezones.
     *
     * Based off: https://gist.github.com/serverdensity/82576
     *
     * @return array
     */
    public function getTimezoneList()
    {
        $locations = [];
        $zones = timezone_identifiers_list();

        $continentNames = [
            'Africa', 'America', 'Antarctica', 'Arctic', 'Asia',
            'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific',
        ];

        foreach ($zones as $zone) {
            $zoneExploded = explode('/', $zone); // 0 => Continent, 1 => City

            // Only use "friendly" continent names
            if (!in_array($zoneExploded[0], $continentNames)) {
                continue;
            }

            if (!isset($zoneExploded[1])) {
                continue;
            }
            $area = str_replace('_', ' ', $zoneExploded[1]);

            if (!empty($zoneExploded[2])) {
                $area = $area.' ('.str_replace('_', ' ', $zoneExploded[2]).')';
            }

            $offset = (new DateTime('now', new DateTimeZone($zone)))->getOffset();
            $locations[$zoneExploded[0]][$zone] = sprintf('UTC%s%s %s',
                ($offset < 0 ? '-' : '+'),
                gmdate('H:i', abs($offset)),
                $area
            );
        }

        return $locations;
    }
}
