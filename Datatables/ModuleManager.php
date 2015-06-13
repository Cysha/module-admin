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
                'filtering'     => true,
                'pagination'    => true,
                'sorting'       => true,
                'sort_column'   => 'order',
                'source'        => null,
                'collection'    => function () {
                    $modules = [];

                    // get the currently installed list of modules
                    foreach (File::directories(app_path('Modules/')) as $directory) {
                        // grab the module name
                        $moduleName = class_basename($directory);

                        $modules[] = (object) [
                            'module' => json_decode(file_get_contents($directory.'/module.json')),
                            'composer' => json_decode(file_get_contents($directory.'/composer.json')),
                        ];
                    }


                    return new Collection($modules);
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
                        return $model->module->order;
                    },
                    'sorting' => true,
                    'filtering' => true,
                    'width' => '10%',
                ],

                'name' => [
                    'th' => 'Name',
                    'tr' => function ($model) {
                        return $model->module->name;
                    },
                    'sorting' => true,
                    'filtering' => true,
                    'width' => '10%',
                ],

                'author' => [
                    'th' => 'Author',
                    'tr' => function ($model) {
                        $authors = null;

                        foreach ($model->module->authors as $author) {
                            $authors .= sprintf('%s<br />', $author->name);
                        }

                        return $authors;
                    },
                    'sorting' => true,
                    'filtering' => true,
                    'width' => '20%',
                ],

                'version' => [
                    'th' => 'Version',
                    'tr' => function ($model) {
                        return $model->module->version;
                    },
                    'sorting' => true,
                    'filtering' => true,
                    'width' => '10%',
                ],

                'keywords' => [
                    'th' => 'Keywords',
                    'tr' => function ($model) {
                        $keywords = null;
                        if (empty($model->module->keywords)) {
                            return $keywords;
                        }

                        $tpl = '<span class="label label-default">%s</span>&nbsp;';
                        foreach ($model->module->keywords as $keyword) {
                            $keywords .= sprintf($tpl, $keyword);
                        }

                        return $keywords;
                    },
                    'width' => '25%',
                ],

                'active' => [
                    'th' => 'Active',
                    'tr' => function ($model) {
                        return $model->module->active === 1
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
                                'btn-link'  => route('admin.user.view', $model->id),
                                'btn-class' => 'btn btn-default btn-xs btn-labeled',
                                'btn-icon'  => 'fa fa-file-text-o'
                            ];
                        }

                        if (Lock::can('manage.update', 'auth_user')) {
                            $return[] = [
                                'btn-title' => 'Edit',
                                'btn-link'  => route('admin.user.edit', $model->id),
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
