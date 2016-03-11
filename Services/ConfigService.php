<?php

namespace Cms\Modules\Admin\Services;

use Illuminate\Contracts\Config\Repository as Config;
use Pingpong\Modules\Repository as Module;
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

    public function getIndexRoutes()
    {
        // grab a list of all the index routes
        $indexRoutes = [];

        // grab the module list
        if (!count($this->modules->enabled())) {
            return $indexRoutes;
        }

        foreach ($this->modules->getOrdered() as $module) {
            // make sure the module is enabled
            if (!$module->enabled()) {
                continue;
            }

            // test for the pre-defined config string
            $configStr = sprintf('cms.%s.config.pxcms-index', $module->getLowerName());
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
                    $name = 'Homepage Route';
                }

                // add this route to the array to pass back
                $indexRoutes = array_merge($indexRoutes, [$route => '['.$module->getStudlyName().'] '.$name]);
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

        foreach ($zones as $zone) {
            $zoneExploded = explode('/', $zone); // 0 => Continent, 1 => City

            // Only use "friendly" continent names
            if ($zoneExploded[0] == 'Africa' || $zoneExploded[0] == 'America' || $zoneExploded[0] == 'Antarctica' || $zoneExploded[0] == 'Arctic' || $zoneExploded[0] == 'Asia' || $zoneExploded[0] == 'Atlantic' || $zoneExploded[0] == 'Australia' || $zoneExploded[0] == 'Europe' || $zoneExploded[0] == 'Indian' || $zoneExploded[0] == 'Pacific') {
                if (isset($zoneExploded[1]) != '') {
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
            }
        }

        return $locations;
    }
}
