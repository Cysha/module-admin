<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Navigation;

use Cms\Modules\Admin\Datatables\NavigationManager;
use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Http\Requests\BackendCreateNavigationRequest;
use Cms\Modules\Admin\Traits\DataTableTrait;
use Cms\Modules\Core\Models\Navigation;
use Former\Facades\Former;

class NavController extends BaseAdminController
{
    use DataTableTrait;

    public function manager()
    {
        return $this->renderDataTable(with(new NavigationManager())->boot());
    }

    public function create()
    {
        $this->theme->setTitle('Create Navigation');
        $this->theme->breadcrumb()->add('Manage Navigation', route('admin.nav.manager'));
        $this->theme->breadcrumb()->add('Create Nav', route('admin.nav.create'));

        return $this->setView('admin.navigation.form');
    }

    public function update(Navigation $nav)
    {
        $this->theme->setTitle(sprintf('Manage Navigation > %s', $nav->name));
        $this->theme->breadcrumb()->add('Manage Navigation', route('admin.nav.manager'));
        $this->theme->breadcrumb()->add('Update Nav', route('admin.nav.update', $nav->name));

        Former::populate($nav);

        return $this->setView('admin.navigation.form', compact('nav'));
    }

    public function store(BackendCreateNavigationRequest $request)
    {
        $input = $request->only(['name', 'class']);

        $nav = with(new Navigation())->updateOrCreate(
            ['name' => array_get($input, 'name')],
            $input
        );

        if ($nav->save() === false) {
            return redirect()->back()
                ->withErrors($nav->getErrors());
        }

        return redirect()->to(route('admin.nav.manager'))
            ->withInfo('Navigation Created');
    }
}
