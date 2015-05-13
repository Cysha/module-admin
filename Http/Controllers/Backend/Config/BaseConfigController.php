<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Core;
use Input;

class BaseConfigController extends BaseAdminController
{
    public function boot()
    {
        parent::boot();

        $this->theme->breadcrumb()->add('Configuration Manager', route('admin.config.index'));
    }

    /**
     * Save the settings passed in
     * @return bool
     */
    public function postStoreConfig()
    {
        $settings = Input::except('_token');

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

}
