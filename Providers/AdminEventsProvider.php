<?php namespace Cms\Modules\Admin\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Cms\Modules\Core\Providers\BaseEventsProvider;
use Cms\Modules\Core;
use Cms\Modules\Admin;
use Cache;

class AdminEventsProvider extends BaseEventsProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Cms\Modules\Admin\Events\ConfigWasSaved' => [
            'Cms\Modules\Admin\Events\Handlers\SetDebug',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

    ];


    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Core\Models\DBConfig::saved(function ($model) {
            Cache::forget('core.config_table');
            event(new Admin\Events\ConfigWasSaved($model->key, $model->value));
        });
    }
}
