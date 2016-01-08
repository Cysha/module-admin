<?php namespace Cms\Modules\Admin\Composers;

use Illuminate\Contracts\Config\Repository as Config;
use Cms\Modules\Auth\Repositories\User\RepositoryInterface as UserRepo;
use GuzzleHttp\Client;
use File;

class Widgets
{
    /**
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var Cms\Modules\Auth\Repositories\User\RepositoryInterface
     */
    protected $user;

    public function __construct(Config $config, UserRepo $user)
    {
        $this->config = $config;
        $this->user = $user;
    }

    /**
     * Get User Count
     */
    public function UserCount($view)
    {
        $count = $this->user->all()->count();
        $view->with('counter', $count);
    }

    public function LatestUsers($view)
    {
        $users =  $this->user->transformModels($this->user->orderBy('created_at', 'desc')->limit(8)->get());
        $view->with('users', $users);
    }

    public function CmsUpdate($view)
    {
        // grab the repo commits
        $url = 'https://api.github.com/repos/Cysha/PhoenixCMS/commits';
        $response = with(new Client)->get($url);
        $github = $response->json();

        $currentVersion = 'Unknown';
        if (File::exists(base_path().'/.git/FETCH_HEAD')) {
            $currentVersion = substr(File::get(base_path().'/.git/FETCH_HEAD'), 0, 40);
        }

        $view->with('info', [
            'upToDate'       => $currentVersion != 'Unknown' ? (array_get($github, '0.sha') == $currentVersion) : null,
            'currentVersion' => $currentVersion,
            'commits'        => array_slice($github, 0, 3),
        ]);
    }

    public function MemoryUsage($view)
    {
        $pid = getmypid();
        exec("ps -eo%mem,rss,pid | grep $pid", $output);

        $return = explode('  ', $output[0]);

        $view->with('memory', convertUnits($return[1] * 1024));
    }

}
