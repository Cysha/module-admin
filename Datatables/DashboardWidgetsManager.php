<?php

namespace Cms\Modules\Admin\Datatables;

class DashboardWidgetsManager
{
    public function boot()
    {
        return [
            /*
             * Page Decoration Values
             */
            'page' => [
                'title' => 'Dashboard Widgets',
                'header' => [
                    [
                        'btn-text' => 'Add New Widget Instance',
                        'btn-url' => '#',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon' => 'fa fa-plus',
                        'btn-extras' => 'data-toggle="modal" data-target="#addWidget"',
                    ],
                ],
            ],

            /*
             * Set up some table options, these will be passed back to the view
             */
            'options' => [
                'pagination' => false,
                'searching' => true,
                'column_search' => false,
                'ordering' => true,
                'sort_column' => 'id',
                'sort_order' => 'asc',
                'source' => 'admin.config.dashboard',
                'collection' => function () {
                    $model = 'Cms\Modules\Admin\Models\Widget';

                    return $model::with('options')->get();
                },
            ],

            /*
             * Lists the tables columns
             */
            'columns' => [
                'id' => [
                    'th' => 'ID',
                    'tr' => function ($model) {
                        return $model->id;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    // 'width' => '10%',
                ],

                'component' => [
                    'th' => 'Component',
                    'tr' => function ($model) {
                        return $model->component;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    // 'width' => '10%',
                ],

                'grid' => [
                    'th' => 'Location',
                    'tr' => function ($model) {
                        return $model->grid;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    // 'width' => '10%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        $return = [];

                        if (hasPermission('manage.update', 'admin_dashboard')) {
                            $return[] = [
                                'btn-title' => 'Edit',
                                'btn-link' => route('admin.widget.update', $model->id),
                                'btn-class' => 'btn btn-default btn-xs btn-labeled',
                                'btn-icon' => 'fa fa-pencil',
                            ];
                        }

                        if (hasPermission('manage.delete', 'admin_dashboard')) {
                            $return[] = [
                                'btn-title' => 'Delete',
                                'btn-link' => route('admin.widget.delete', $model->id),
                                'btn-class' => 'btn btn-danger btn-xs btn-labeled',
                                'btn-icon' => 'fa fa-times',
                                'btn-method' => 'delete',
                                'btn-extras' => 'data-remote="true" data-confirm="Are you sure you want to delete this widget?" data-disable-with="<i class=\'fa fa-refresh fa-spin\'></i>"',
                            ];
                        }

                        return $return;
                    },
                ],
            ],
        ];
    }
}
