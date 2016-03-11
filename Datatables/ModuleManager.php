<?php

namespace Cms\Modules\Admin\Datatables;

use Illuminate\Support\Collection;
use Lock;

class ModuleManager
{
    public function boot()
    {
        return [
            /*
             * Page Decoration Values
             */
            'page' => [
                'title' => '<i class="fa fa-fw fa-puzzle-piece"></i> Module Manager',
                'alert' => [
                    'class' => 'info',
                    'text' => '<i class="fa fa-info-circle"></i> The modules below are what you have installed.',
                ],
                'header' => [
                    [
                        'btn-text' => 'Check for Updates',
                        'btn-link' => 'admin.modules.update',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon' => 'fa fa-fw fa-refresh',
                    ],
                ],
            ],

            /*
             * Set up some table options, these will be passed back to the view
             */
            'options' => [
                'pagination' => false,
                'searching' => false,
                'ordering' => false,
                'sort_column' => 'order',
                'sort_order' => 'desc',
                'source' => null,
                'collection' => function () {
                    $model = 'Cms\Modules\Core\Models\Module';

                    return $model::all();
                },
            ],

            /*
             * Lists the tables columns
             */
            'columns' => [
                // 'Debug' => [
                //     'th' => 'Debug',
                //     'tr' => function ($model) {
                //         return \Debug::dump($model);
                //     },
                //     'width'     => '80%',
                // ],

                'order' => [
                    'th' => 'Load Order',
                    'tr' => function ($model) {
                        return array_get($model, 'order', null);
                    },
                    'orderable' => true,
                    'width' => '5%',
                ],

                'name' => [
                    'th' => 'Name',
                    'tr' => function ($model) {
                        return array_get($model, 'name', null);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'alias' => [
                    'th' => 'Namespace',
                    'tr' => function ($model) {
                        return array_get($model, 'alias', null);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
                ],

                'author' => [
                    'th' => 'Author',
                    'tr' => function ($model) {
                        $authors = null;
                        if (empty(array_get($model, 'authors', null))) {
                            return $authors;
                        }

                        foreach (array_get($model, 'authors', null) as $author) {
                            $authors .= sprintf('%s<br />', $author->name);
                        }

                        return $authors;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'version' => [
                    'th' => 'Version',
                    'tr' => function ($model) {
                        return array_get($model, 'version', null);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '7%',
                ],

                'keywords' => [
                    'th' => 'Keywords',
                    'tr' => function ($model) {
                        $keywords = null;
                        if (empty(array_get($model, 'keywords', null))) {
                            return $keywords;
                        }

                        $tpl = '<span class="label label-default">%s</span>&nbsp;';
                        foreach (array_get($model, 'keywords', null) as $keyword) {
                            $keywords .= sprintf($tpl, $keyword);
                        }

                        return $keywords;
                    },
                    'width' => '25%',
                ],

                'active' => [
                    'th' => 'Active',
                    'tr' => function ($model) {
                        return array_get($model, 'active', null)
                            ? '<div class="label label-success">Active</div>'
                            : '<div class="label label-danger">Not Active</div>';
                    },
                    'width' => '7%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        return [];
                        $return = [];
                        $keywords = !empty(array_get($model, 'keywords', null)) ? array_get($model, 'keywords', null) : [];

                        // core modules should not be disabled o.O
                        if (in_array('core-module', $keywords)) {
                            return $return;
                        }

                        if (array_get($model, 'active', null)) {
                            $return[] = [
                                'btn-title' => 'Disable Module',
                                'btn-link' => route('admin.modules.disable', array_get($model, 'alias', null)),
                                'btn-class' => 'btn btn-xs btn-labeled btn-danger',
                                'btn-icon' => 'fa fa-lock',
                                'btn-method' => 'post',
                                'btn-extras' => 'data-remote="true" data-confirm="Are you sure you want to disable '.array_get($model, 'name', null).'?" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                                'hasPermission' => 'module.toggle@admin_modules',
                            ];
                        } else {
                            $return[] = [
                                'btn-title' => 'Enable Module',
                                'btn-link' => route('admin.modules.enable', array_get($model, 'alias', null)),
                                'btn-class' => 'btn btn-xs btn-labeled btn-success',
                                'btn-icon' => 'fa fa-unlock',
                                'btn-method' => 'post',
                                'btn-extras' => 'data-remote="true" data-confirm="Are you sure you want to enable '.array_get($model, 'name', null).'?" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                                'hasPermission' => 'module.toggle@admin_modules',
                            ];
                        }

                        return $return;
                    },
                ],
            ],
        ];
    }
}
