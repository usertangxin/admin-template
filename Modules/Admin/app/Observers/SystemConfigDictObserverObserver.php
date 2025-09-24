<?php

namespace Modules\Admin\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;

class SystemConfigDictObserverObserver
{
    private function forgetCache($model): void
    {
        $config_cache_name_map = config('admin.cache_name_map');
        $cacheMap              = [
            SystemConfig::class      => $config_cache_name_map['system_config_list'],
            SystemConfigGroup::class => $config_cache_name_map['system_config_group_list'],
            SystemDict::class        => $config_cache_name_map['system_dict_list'],
            SystemDictType::class    => $config_cache_name_map['system_dict_group_list'],
        ];

        $cacheKey = $cacheMap[get_class($model)];
        Cache::forget($cacheKey);
        Cache::forget($config_cache_name_map['system_config_dict_hash']);
    }

    public function created($model): void
    {
        $this->forgetCache($model);
    }

    public function updated($model): void
    {
        $this->forgetCache($model);
    }

    public function deleted($model): void
    {
        $this->forgetCache($model);
    }

    public function restored($model): void
    {
        $this->forgetCache($model);
    }

    public function forceDeleted($model): void
    {
        $this->forgetCache($model);
    }
}
