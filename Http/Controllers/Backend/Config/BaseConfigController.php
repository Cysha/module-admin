<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Input;

class BaseConfigController extends BaseAdminController
{
    public function boot()
    {
        parent::boot();

        $this->theme->breadcrumb()->add('Configuration Manager', route('admin.config.website'));
    }

    /**
     * Save the settings passed in.
     *
     * @return bool
     */
    public function postStoreConfig()
    {
        $settings = array_except($this->getRealInput(), '_token');

        $failed = [];
        foreach ($settings as $setting => $value) {
            $saved = save_config_var($setting, $value);

            // if the save failed, add it to the array to be passed back
            if ($saved === false) {
                $failed[] = $setting;
            }
        }

        if (count($failed)) {
            return redirect()->back()->withError('Config Save partially failed. The following keys could not be saved: <ul><li>'.implode('</li><li>', $setting).'</li></ul>');
        }

        return redirect()->back()->withInfo('Config Saved');
    }

    /**
     * PHP replaces .'s with _'s in most variables and many others,
     * this function will get the real var names.
     *
     * @see  http://php.net/manual/en/language.variables.external.php
     */
    private function getRealInput()
    {
        $input = file_get_contents('php://input');
        $return = [];
        if (empty($input)) {
            return $return;
        }

        $input = explode('&', $input);
        if (!is_array($input)) {
            return $return;
        }

        foreach ($input as $pair) {
            list($name, $value) = explode('=', $pair);

            $return[urldecode($name)] = urldecode($value);
        }

        return $return;
    }
}
