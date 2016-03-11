<?php

namespace Cms\Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;

class ConfigWasSaved
{
    use SerializesModels;

    public $key;
    public $value;

    /**
     * Create a new event instance.
     *
     * @param string $key   the config key that was saved
     * @param mixed  $value the value that it was saved with
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
