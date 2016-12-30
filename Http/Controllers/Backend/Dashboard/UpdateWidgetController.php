<?php

namespace Cms\Modules\Admin\Http\Controllers\Backend\Dashboard;

use Cms\Modules\Admin\Http\Controllers\Backend\BaseAdminController;
use Cms\Modules\Admin\Models\Widget;
use Cms\Modules\Admin\Models\WidgetOptions;
use Cms\Modules\Admin\Services\DashboardService;
use Former\Facades\Former;
use Illuminate\Http\Request;

class UpdateWidgetController extends BaseAdminController
{
    public function getForm(Widget $widget, DashboardService $dashboard)
    {
        $this->theme->setTitle(sprintf('Editing Widget > <small>%s</small>', $widget->component));
        Former::populate($dashboard->getGridLayout()
            ->where('id', $widget->id)
            ->first());

        // see if we can find an update view for this component
        $view = $dashboard->hasUpdateView($widget->component);
        if ($view === null) {
            $view = 'admin::admin.dashboard.widgets.default';
        }

        // split it into module and view
        list($module, $view) = explode('::', $view);

        return $this->setView($view, [], 'module:'.$module);
    }

    public function postForm(Widget $widget, Request $request)
    {
        // update main widget entry
        $widget->grid = $request->get('grid');

        if ($widget->isDirty()) {
            if (!$widget->save()) {
                return redirect()->back()
                    ->withError('Widget save failed, please try again!');
            }
        }

        // grab all the widgets
        $widgetOptions = WidgetOptions::all();

        // roll over each option, and update/create an entry
        foreach ($request->get('options') as $key => $value) {
            $option = $widgetOptions
                ->where('dashboard_widget_id', $widget->id)
                ->where('key', $key)
                ->first();
            if ($option === null) {
                $option = new WidgetOptions();
                $option->fill([
                    'dashboard_widget_id' => $widget->id,
                    'key' => $key,
                ]);
            }

            $option->value = $value;

            if ($option->isDirty()) {
                if (!$option->save()) {
                    return redirect()->back()
                        ->withError('Widget options save failed, please try again!');
                }
            }
        }

        return redirect()->back()->withInfo('Widget Update Successful');
    }

    public function delete(Widget $widget)
    {
        $widgetOptions = WidgetOptions::where('dashboard_widget_id', $widget->id);

        if ($widgetOptions->count() > 0) {
            if (!$widgetOptions->delete()) {
                return redirect()->back()
                    ->withError('Could not delete widget options.');
            }
        }

        if (!$widget->delete()) {
            return redirect()->back()->withError('Could not delete widget');
        }

        return redirect()->back()->withInfo('Widget and Options deleted successfully');
    }
}
