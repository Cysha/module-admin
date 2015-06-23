<?php namespace Cms\Modules\Admin\Http\Controllers\Backend\Config;

use Illuminate\Http\Request;

class CacheController extends BaseConfigController
{
    public function getIndex()
    {
        $this->theme->setTitle('Cache Configuration');
        $this->theme->breadcrumb()->add('Cache Configuration', route('admin.config.cache'));

        return $this->setView('admin.config.cache', [
            'keys' => $this->getCacheKeys(),
        ], 'module');
    }

    public function postIndex(Request $input)
    {
        $clearKeys = $input->get('cache');

        $cacheKeys = $this->getCacheKeys();

        $cache_flushed = false;
        foreach ($clearKeys as $key) {
            if (!in_array($key, $clearKeys)) {
                continue;
            }

            cache_flush($key);
            $cache_flushed = true;
        }

        if ($cache_flushed === false) {
            return redirect()->back()
                ->withError('Could not flush cache keys. Please try again.');
        }

        return redirect()->back()
            ->withInfo('Flushed cache keys successfully.');
    }

    private function getCacheKeys()
    {
        $keys = [];

        // loop through each of the menus, merge them into the menus arr
        foreach (get_array_column(config('cms'), 'admin.cache_keys') as $moduleName => $cacheKeys) {
            $module = app('modules')->find($moduleName);
            // quick check to make sure the module isnt enabled
            if ($module === null || !$module->enabled()) {
                continue;
            }

            $keys = array_merge_recursive($keys, $cacheKeys);
        }

        return $keys;
    }

}
