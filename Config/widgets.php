<?php

return [
    'dashboard' => [
        [
            'view'  => 'admin::widgets.cmsUpdate',
            'name'  => 'CMS Update Info',
            'class' => '\Cms\Modules\Admin\Composers\Widgets@CmsUpdate',
        ],
        [
            'view'  => 'admin::widgets.userCount',
            'name'  => 'User Count',
            'class' => '\Cms\Modules\Admin\Composers\Widgets@UserCount',
        ],
        [
            'view'  => 'admin::widgets.loadAvg',
            'name'  => 'Load Average',
            'class' => '\Cms\Modules\Admin\Composers\Widgets@LatestUsers',
        ],
        [
            'view'  => 'admin::widgets.memoryUsage',
            'name'  => 'Memory Usage',
            'class' => '\Cms\Modules\Admin\Composers\Widgets@MemoryUsage',
        ],
        [
            'view'  => 'admin::widgets.latestUsers',
            'name'  => 'Latest Registered Users',
            'class' => '\Cms\Modules\Admin\Composers\Widgets@LatestUsers',
        ],
    ],

];
