<?php

namespace Cms\Modules\Admin\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class DebugSetCommand extends Command
{
    protected $name = 'cms:debug';
    protected $readableName = 'Sets the cms\'s debug setting';
    protected $description = 'Sets the cms\'s debug setting';

    public function fire()
    {
        $settingStr = 'cms.core.app.debug';
        $configValue = config($settingStr) === 'true' ? true : false;
        $newSetting = null;
        if ($this->argument('setting') !== null) {
            $newSetting = ($this->argument('setting') === 'on' ? true : false);
        }

        switch ($newSetting) {
            case null :
                $this->info('Debug Turned: '.(!$configValue ? 'On' : 'Off'));
                save_config_var($settingStr, (!$configValue ? 'true' : 'false'));
            break;

            case true :
                $this->info('Debug Turned: On');
                save_config_var($settingStr, 'true');
            break;

            case false :
                $this->info('Debug Turned: Off');
                save_config_var($settingStr, 'false');
            break;
        }
        $this->callSilent('cache:clear');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['setting', InputArgument::OPTIONAL, 'The debug value.', null],
        ];
    }
}
