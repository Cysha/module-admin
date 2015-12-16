<?php


if (!function_exists('save_config_var')) {
    function save_config_var($setting, $value, $env = null)
    {
        $configModel = new \Cms\Modules\Core\Models\DBConfig();

        $settingInfo = $configModel->explodeSetting($setting);

        if (empty($env)) {
            $env = $settingInfo['environment'];
        }

        // check to see if we already have this setting going
        $DBConfig = with(new $configModel())->where('environment', $env);
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
            $DBConfig = with(new $configModel());
            $saved = $DBConfig->set($setting, $value);
        }

        return $saved;
    }
}

if (!function_exists('convertUnits')) {
    function convertUnits($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;

        return number_format($size / pow(1024, $power), 2, '.', ',').' '.$units[$power];
    }
}

if (!function_exists('build_helper_buttons')) {
    function build_helper_button(array $btn)
    {
        // check for permissions
        $perm = array_pull($btn, 'hasPermission', null);
        if ($perm !== null && !hasPermission($perm)) {
            return;
        }

        // the button structure, basic text, tooltip or just icon
        if (isset($btn['btn-text'])) {
            $tpl = '<span class="btn-label"><i class="%s fa-fw"></i></span> <span>%s</span>';
            $label = sprintf($tpl, array_get($btn, 'btn-icon'), array_get($btn, 'btn-text', null));
        } elseif (isset($btn['btn-title'])) {
            $tpl = '<span title="%2$s" data-toggle="tooltip"><i class="%1$s fa-fw"></i></span>';
            $label = sprintf($tpl, array_get($btn, 'btn-icon'), array_get($btn, 'btn-title', null));
        } else {
            $tpl = '<i class="%s fa-fw"></i>';
            $label = sprintf($tpl, array_get($btn, 'btn-icon'));
        }

        $extras = [];
        // check for ujs method
        if (isset($btn['btn-method'])) {
            $extras[] = 'data-method="'.array_get($btn, 'btn-method', 'GET').'"';
        }

        // check for extras key, this will just be a html string
        if (isset($btn['btn-extras'])) {
            $extras[] = array_get($btn, 'btn-extras');
        }

        // figure out where to link this to
        $url = '#';
        if (($route = array_get($btn, 'btn-route', null)) !== null) {

            // if its an array throw it at route()
            if (is_array($route)) {
                list($route, $arguments) = $route;

                $url = route($route, transform_button_args($arguments));
            } else {
                // else just call it normally
                $url = route($route);
            }
        } elseif (($direct = array_get($btn, 'btn-link', null)) !== null) {
            $url = $direct;
        }

        // build the template
        $tpl = '<a class="%1$s" href="%2$s">%3$s</a>';
        if (!empty($extras)) {
            $tpl = '<a class="%1$s" href="%2$s" '.implode(' ', $extras).'>%3$s</a>';
        }

        // build the button wrapper
        return sprintf($tpl, array_get($btn, 'btn-class'), $url, $label);
    }
}
