<?php

namespace Cms\Modules\Admin\Composers;

use GuzzleHttp\Client;
use File;

class Widgets
{
    public function CmsUpdate($view)
    {
        // grab the repo commits
        $url = 'https://api.github.com/repos/Cysha/PhoenixCMS/commits';
        $response = with(new Client())->get($url);
        $github = json_decode($response->getBody(), true);

        $currentVersion = 'Unknown';
        if (File::exists(base_path().'/.git/FETCH_HEAD')) {
            $currentVersion = substr(File::get(base_path().'/.git/FETCH_HEAD'), 0, 40);
        }

        $view->with('info', [
            'upToDate' => $currentVersion != 'Unknown' ? (array_get($github, '0.sha') == $currentVersion) : null,
            'currentVersion' => $currentVersion,
            'commits' => array_slice($github, 0, 3),
        ]);
    }
}
