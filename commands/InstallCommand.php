<?php namespace Cysha\Modules\Admin\Commands;

use Cysha\Modules\Core\Commands\BaseCommand;

class InstallCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms.modules.admin:install';

    /**
     * The Readable Module Name.
     *
     * @var string
     */
    protected $readableName = 'Admin Module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the Admin Module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $packages = array(
            'chumper/datatable' => array(
                'name'      => 'DataTables',
                'config'    => true,
            ),
        );

        $this->install($packages);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
        );
    }

}
