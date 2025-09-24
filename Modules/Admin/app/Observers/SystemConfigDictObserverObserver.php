<?php

namespace Modules\Admin\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;

class SystemConfigDictObserverObserver
{
    private $cacheMap = [
        SystemConfig::class => 'system_config_list',
        SystemConfigGroup::class => 'system_config_group_list',
        SystemDict::class => 'system_dict_list',
        SystemDictType::class => 'system_dict_group_list',
    ];

    private function forgetCache($model): void
    {
        $cacheKey = $this->cacheMap[get_class($model)];
        Cache::forget($cacheKey);
        Cache::forget('system_config_dict_hash');
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
