<?php namespace Cms\Modules\Admin\Datatables;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Lock;

class ModuleManager
{
    public function boot()
    {
        return [
            /**
             * Page Decoration Values
             */
            'page' => [
                'title' => '<i class="fa fa-fw fa-puzzle-piece"></i> Module Manager',
                'alert' => [
                    'class' => 'info',
                    'text'  => '<i class="fa fa-info-circle"></i> The modules below are what you have installed.'
                ],
                'header' => [
                    [
                        'btn-text' => 'Check for Updates',
                        'btn-link'  => 'admin.modules.update',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon'  => 'fa fa-fw fa-refresh'
                    ]
                ]
            ],

            /**
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

            /**
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
                        return $model->order;
                    },
                    'orderable' => true,
                    'width' => '5%',
                ],

                'name' => [
                    'th' => 'Name',
                    'tr' => function ($model) {
                        return $model->name;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'alias' => [
                    'th' => 'Namespace',
                    'tr' => function ($model) {
                        return $model->alias;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
                ],

                'author' => [
                    'th' => 'Author',
                    'tr' => function ($model) {
                        $authors = null;
                        if (empty($model->authors)) {
                            return $authors;
                        }

                        foreach ($model->authors as $author) {
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
                        return $model->version;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '7%',
                ],

                'keywords' => [
                    'th' => 'Keywords',
                    'tr' => function ($model) {
                        $keywords = null;
                        if (empty($model->keywords)) {
                            return $keywords;
                        }

                        $tpl = '<span class="label label-default">%s</span>&nbsp;';
                        foreach ($model->keywords as $keyword) {
                            $keywords .= sprintf($tpl, $keyword);
                        }

                        return $keywords;
                    },
                    'width' => '25%',
                ],

                'active' => [
                    'th' => 'Active',
                    'tr' => function ($model) {
                        return $model->active
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
                        $keywords = !empty($model->keywords) ? $model->keywords : [];

                        // core modules should not be disabled o.O
                        if (in_array('core-module', $keywords)) {
                            return $return;
                        }

                        if ($model->active) {
                            $return[] = [
                                'btn-title' => 'Disable Module',
                                'btn-link'  => route('admin.modules.disable', $model->alias),
                                'btn-class' => 'btn btn-xs btn-labeled btn-danger',
                                'btn-icon'  => 'fa fa-lock',
                                'btn-method' => 'post',
                                'btn-extras' => 'data-remote="true" data-confirm="Are you sure you want to disable '.$model->name.'?" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                                'hasPermission' => 'module.toggle@admin_modules',
                            ];
                        } else {
                            $return[] = [
                                'btn-title' => 'Enable Module',
                                'btn-link'  => route('admin.modules.enable', $model->alias),
                                'btn-class' => 'btn btn-xs btn-labeled btn-success',
                                'btn-icon'  => 'fa fa-unlock',
                                'btn-method' => 'post',
                                'btn-extras' => 'data-remote="true" data-confirm="Are you sure you want to enable '.$model->name.'?" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                                'hasPermission' => 'module.toggle@admin_modules',
                            ];
                        }

                        return $return;
                    },
                ],
            ]
        ];

    }
}
