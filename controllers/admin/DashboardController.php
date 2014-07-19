<?php namespace Cysha\Modules\Admin\Controllers\Admin;

use Cysha\Modules\Admin\Controllers\BaseAdminController;

class DashboardController extends BaseAdminController
{
    public function getIndex()
    {

        return $this->setView('admin.dashboard.index', array(
        ), 'module');
    }

}
