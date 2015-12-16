<?php

namespace Cms\Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;

class GotDatatableConfig
{
    use SerializesModels;

    public $config;

    /**
     * Create a new event instance.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __construct($config)
    {
        $this->config = $config;
    }
}
