<?php

namespace Cms\Modules\Admin\Models;

class Widget extends BaseModel
{
    public $table = 'dashboard_widgets';
    public $timestamps = false;

    protected $fillable = ['component', 'grid'];

    public function options()
    {
        return $this->hasMany(WidgetOptions::class, 'dashboard_widget_id', 'id');
    }
}
