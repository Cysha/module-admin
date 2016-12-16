<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Navigation;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Http\Requests\BackendCreateNavLinkRequest;
use Cms\Modules\Core\Models\Navigation;
use Cms\Modules\Core\Models\NavigationLink;
use Former\Facades\Former;
use Illuminate\Http\Request;

class NavLinksController extends BaseAdminController
{
    public function create(Navigation $nav, NavigationLink $navLink)
    {
        $this->theme->setTitle(sprintf('Manage Navigation > %s', $nav->name));
        $this->theme->breadcrumb()->add('Manage Navigation', route('admin.nav.manager'));
        $this->theme->breadcrumb()->add('Nav Update', route('admin.nav.update', $nav->name));

        Former::populate($navLink);

        return $this->setView('admin.nav-links.form', compact('nav'));
    }

    public function update(Navigation $nav, NavigationLink $navLink)
    {
        $this->theme->setTitle(sprintf('Manage Navigation > %s', $nav->name));
        $this->theme->breadcrumb()->add('Manage Navigation', route('admin.nav.manager'));
        $this->theme->breadcrumb()->add('Nav Update', route('admin.nav.update', $nav->name));

        Former::populate($navLink);

        return $this->setView('admin.nav-links.form', compact('nav'));
    }

    public function store(Navigation $nav, NavigationLink $navLink, BackendCreateNavLinkRequest $request)
    {
        $input = $request->only(['title', 'class', 'blank', 'url', 'route']);

        $input['navigation_id'] = $nav->id;

        $link = with(new NavigationLink())->updateOrCreate(
            ['title' => array_get($input, 'title')],
            $input
        );

        if ($link->save() === false) {
            return redirect()->back()
                ->withErrors($link->getErrors());
        }

        return redirect()->to(route('admin.nav.update', $nav->name))
            ->withInfo('Link Created/Updated');
    }

    public function postDown(Navigation $nav, NavigationLink $link, Request $input)
    {
        ++$link->order;

        if ($link->save() === false) {
            return redirect()->to(route('admin.nav.update', $nav->name))
                ->withError('Link order wasn\'t updated. Please try again.');
        }

        return redirect()->to(route('admin.nav.update', $nav->name))
            ->withInfo('Link Order updated successfully.');
    }

    public function postUp(Navigation $nav, NavigationLink $link, Request $input)
    {
        if (($link->order - 1) <= 0) {
            $link->order = 1;
        } else {
            --$link->order;
        }

        if ($link->save() === false) {
            return redirect()->to(route('admin.nav.update', $nav->name))
                ->withError('Link order wasn\'t updated. Please try again.');
        }

        return redirect()->to(route('admin.nav.update', $nav->name))
            ->withInfo('Link Order updated successfully.');
    }
}
