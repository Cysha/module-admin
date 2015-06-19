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
                    $modules = new Collection;

                    // get the currently installed list of modules
                    foreach (File::directories(app_path('Modules/')) as $directory) {
                        $moduleName = class_basename($directory);

                        $module = json_decode(file_get_contents($directory.'/module.json'));
                        //$composer = json_decode(file_get_contents($directory.'/composer.json'));

                        $modules->push((object) [
                            'order' => (int) $module->order,
                            'name' => $module->name,
                            'authors' => $module->authors,
                            'version' => $module->version,
                            'keywords' => $module->keywords,
                            'active' => $module->active,
                        ]);
                    }

                    return $modules;
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
                    'width' => '10%',
                ],

                'name' => [
                    'th' => 'Name',
                    'tr' => function ($model) {
                        return $model->name;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
                ],

                'author' => [
                    'th' => 'Author',
                    'tr' => function ($model) {
                        $authors = null;

                        foreach ($model->authors as $author) {
                            $authors .= sprintf('%s<br />', $author->name);
                        }

                        return $authors;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '20%',
                ],

                'version' => [
                    'th' => 'Version',
                    'tr' => function ($model) {
                        return $model->version;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
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
                        return $model->active === 1
                            ? '<div class="label label-success">Active</div>'
                            : '<div class="label label-danger">Not Active</div>';
                    },
                    'width' => '10%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        $return = [];
                        return $return;

                        if (Lock::can('manage.read', 'auth_user')) {
                            $return[] = [
                                'btn-title' => 'View User',
                                'btn-link'  => route('admin.user.view', $model->name),
                                'btn-class' => 'btn btn-default btn-xs btn-labeled',
                                'btn-icon'  => 'fa fa-file-text-o'
                            ];
                        }

                        if (Lock::can('manage.update', 'auth_user')) {
                            $return[] = [
                                'btn-title' => 'Edit',
                                'btn-link'  => route('admin.user.edit', $model->name),
                                'btn-class' => 'btn btn-warning btn-xs btn-labeled',
                                'btn-icon'  => 'fa fa-pencil'
                            ];
                        }

                        return $return;
                    },
                ],
            ]
        ];

    }
}
