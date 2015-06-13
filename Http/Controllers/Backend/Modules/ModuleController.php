<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Modules;

use Cms\Modules\Admin\Datatables\ModuleManager;
use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Traits\DataTableTrait;
use Illuminate\Support\Facades\File;

class ModuleController extends BaseAdminController
{
    use DataTableTrait;

    public function manager()
    {
        return $this->renderDataTable(with(new ModuleManager)->boot());
    }

}
