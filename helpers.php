<?php


if (!function_exists('save_config_var')) {
    function save_config_var($setting, $value, $env = null)
    {
        $configModel = new \Cms\Modules\Core\Models\DBConfig;

        $settingInfo = $configModel->explodeSetting($setting);

        if (empty($env)) {
            $env = $settingInfo['environment'];
        }

        // check to see if we already have this setting going
        $DBConfig = with(new $configModel)->where('environment', $env);
        if (isset($settingInfo['group'])) {
            $DBConfig->where('group', $settingInfo['group']);
        }

        if (isset($settingInfo['item'])) {
            $DBConfig->where('item', $settingInfo['item']);
        }

        if (isset($settingInfo['namespace'])) {
            $DBConfig->where('namespace', $settingInfo['namespace']);
        }
        $DBConfig = $DBConfig->get()->first();

        $saved = false;
        // if we have a config row already, update the value
        if (count($DBConfig)) {
            $DBConfig->value = $value;
            $saved = $DBConfig->save();

        // else create a new one
        } else {
            // if no value exists and this value is empty, dont bother :)
            if (empty($value)) {
                return true;
            }
            $DBConfig = with(new $configModel);
            $saved = $DBConfig->set($setting, $value);
        }

        return $saved;
    }
}

if (!function_exists('convertUnits')) {
    function convertUnits($size)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}
