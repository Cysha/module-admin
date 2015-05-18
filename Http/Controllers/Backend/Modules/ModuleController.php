<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Modules;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Traits\DataTableTrait;

class ModuleController extends BaseAdminController
{
    use DataTableTrait;

    public function roleManager()
    {
        return $this->renderDataTable('cms.admin.datatable.module-manager');
    }

}
