<?php


if (!function_exists('save_config_var')) {
    function save_config_var($setting, $value, $env = null)
    {
        $setting = str_replace('_', '.', $setting);

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
            $DBConfig = with(new $configModel);
            $saved = $DBConfig->set($setting, $value);
        }

        return $saved;
    }
}
