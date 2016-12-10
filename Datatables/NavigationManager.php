<?php

namespace Cms\Modules\Admin\Datatables;

class NavigationManager
{
    public function boot()
    {
        return [
            /*
             * Page Decoration Values
             */
            'page' => [
                'title' => 'Navigation Manager',
                'header' => [
                    [
                        'btn-text' => 'Create Navigation',
                        'btn-route' => 'admin.nav.create',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon' => 'fa fa-plus',
                    ],
                ],
            ],

            /*
             * Set up some table options, these will be passed back to the view
             */
            'options' => [
                'pagination' => false,
                'searching' => true,
                'column_search' => true,
                'ordering' => true,
                'sort_column' => 'id',
                'sort_order' => 'desc',
                'source' => 'admin.nav.manager',
                'collection' => function () {
                    $model = 'Cms\Modules\Core\Models\Navigation';

                    return $model::with('linkCount')->get();
                },
            ],

            /*
             * Lists the tables columns
             */
            'columns' => [
                'id' => [
                    'th' => '&nbsp;',
                    'tr' => function ($model) {
                        return $model->id;
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
                    'width' => '10%',
                ],
                'class' => [
                    'th' => 'Class',
                    'tr' => function ($model) {
                        return $model->class;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
                ],
                'aggregate' => [
                    'th' => 'Link Count',
                    'tr' => function ($model) {

                        if ($model->getRelation('linkCount')) {
                            return $model->linkCount;
                        }

                        return '0';
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        $return = [];

                        if (hasPermission('manage.update', 'admin_nav')) {
                            $return[] = [
                                'btn-title' => 'Manage',
                                'btn-link' => route('admin.nav.update', $model->name),
                                'btn-class' => 'btn btn-default btn-xs btn-labeled',
                                'btn-icon' => 'fa fa-file-text-o',
                            ];
                        }

                        return $return;
                    },
                ],
            ],
        ];
    }
}
