<?php namespace Cysha\Modules\Admin\Composers;

use GuzzleHttp\Client;
use Config;
use File;

class Widgets
{

    public function UserCount($view)
    {
        $authModel = Config::get('auth.model');
        $view->with('counter', with(new $authModel)->count());
    }

    public function LatestUsers($view)
    {
        $authModel = Config::get('auth.model');
        $users =  with(new $authModel)->orderBy('created_at', 'desc')->take(8)->get()->transform(function ($model) {
            return $model->transform();
        });
        $view->with('users', $users);
    }

    public function CmsUpdate($view)
    {
        // grab the repo commits
        $url = 'https://api.github.com/repos/Cysha/PhoenixCMS/commits';
        $response = with(new Client)->get($url);
        $github = $response->json();

        $currentVersion = substr(File::get(base_path().'/.git/FETCH_HEAD'), 0, 40);

        $view->with('info', [
            'upToDate'       => (array_get($github, '0.sha') == $currentVersion),
            'currentVersion' => $currentVersion,
            'commits'        => array_slice($github, 0, 3),
        ]);
    }

    public function MemoryUsage($view)
    {
        $pid = getmypid();
        exec("ps -eo%mem,rss,pid | grep $pid", $output);

        $return = explode('  ', $output[0]);

        $view->with('memory', convert($return[1] * 1024));
    }

}
