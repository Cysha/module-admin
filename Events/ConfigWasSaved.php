<?php namespace Cms\Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;

class ConfigWasSaved
{
    use SerializesModels;

    public $key;
    public $value;

    /**
     * Create a new event instance.
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
