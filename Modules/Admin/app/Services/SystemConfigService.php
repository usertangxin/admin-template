<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;

/**
 * 系统配置服务
 * 请从容器中获取实例
 */
class SystemConfigService
{
    protected ?Collection $config_group;

    protected ?Collection $config_list;

    public static function getInstance(): static
    {
        return app(self::class);
    }

    /**
     * 获取配置组
     */
    public function getGroups($locale = null): Collection
    {
        if (\app()->runningInConsole() && str_contains(implode(' ', $_SERVER['argv']), 'migrate')) {
            return collect([]);
        }
        $locale ??= app()->getLocale();
        $this->config_group ??= collect(Cache::remember(config('admin.cache_name_map.system_config_group_list') . $locale, 60 * 60 * 24, function () {
            return SystemConfigGroup::all();
        }));

        return $this->config_group;
    }

    /**
     * 刷新配置列表
     */
    public function refresh()
    {
        $this->config_list  = null;
        $this->config_group = null;
    }

    /**
     * 获取配置列表
     */
    public function getList($locale = null): Collection
    {
        $locale ??= app()->getLocale();
        $this->config_list ??= collect(Cache::remember(config('admin.cache_name_map.system_config_list') . $locale, 60 * 60 * 24, function () {
            return SystemConfig::all();
        }));

        return $this->config_list;
    }

    /**
     * 清除配置组缓存
     * @param mixed $locale 
     * @return void 
     * @throws BindingResolutionException 
     */
    public function clearGroupCache($locale = null)
    {
        if ($locale) {
            Cache::forget(config('admin.cache_name_map.system_config_group_list') . $locale);
            return;
        }
        $multi_language = config('admin.multi_language');
        foreach ($multi_language as $item) {
            Cache::forget(config('admin.cache_name_map.system_config_group_list') . $item);
        }
    }

    /**
     * 清除配置列表缓存
     */
    public function clearListCache($locale = null)
    {
        if ($locale) {
            Cache::forget(config('admin.cache_name_map.system_config_list') . $locale);
            return;
        }
        $multi_language = config('admin.multi_language');
        foreach ($multi_language as $item) {
            Cache::forget(config('admin.cache_name_map.system_config_list') . $item);
        }
    }

    /**
     * 获取配置值
     *
     * @return mixed
     */
    public function getValueByKey(string $key, $locale = null)
    {
        return $this->getList($locale)->firstWhere('key', $key)['value'] ?? null;
    }

    /**
     * 获取配置
     *
     * @return mixed
     */
    public function getConfigByKey(string $key, $locale = null)
    {
        return $this->getList($locale)->firstWhere('key', $key);
    }

    public function getListHash($locale = null)
    {
        return sha1($this->getList($locale)->toJson());
    }

    public function getGroupsHash($locale = null)
    {
        return sha1($this->getGroups($locale)->toJson());
    }
}
