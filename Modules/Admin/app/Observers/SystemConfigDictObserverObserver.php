<?php

namespace Modules\Admin\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;
use Modules\Admin\Services\SystemConfigService;
use Modules\Admin\Services\SystemDictService;

class SystemConfigDictObserverObserver
{
    private function forgetCache($model): void
    {
        $config_cache_name_map = config('admin.cache_name_map');
        $cacheMap              = [
            SystemConfig::class      => fn () => app(SystemConfigService::class)->clearListCache($model->getLocale()),
            SystemConfigGroup::class => fn () => app(SystemConfigService::class)->clearGroupCache($model->getLocale()),
            SystemDict::class        => fn () => app(SystemDictService::class)->clearListCache($model->getLocale()),
            SystemDictType::class    => fn () => app(SystemDictService::class)->clearGroupCache($model->getLocale()),
        ];

        $cacheMap[get_class($model)]();

        Cache::forget($config_cache_name_map['system_config_dict_hash'] . $model->getLocale());
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
