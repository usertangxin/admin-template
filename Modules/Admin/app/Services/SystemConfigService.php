<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
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
    public function getGroups(): Collection
    {
        if (\app()->runningInConsole() && str_contains(implode(' ', $_SERVER['argv']), 'migrate')) {
            return collect([]);
        }
        $this->config_group ??= collect(Cache::remember(config('admin.cache_name_map.system_config_group_list'), 60 * 60 * 24, function () {
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
     *
     * @param bool $force
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function getList(): Collection
    {
        $this->config_list ??= collect(Cache::remember(config('admin.cache_name_map.system_config_list'), 60 * 60 * 24, function () {
            return SystemConfig::all();
        }));

        return $this->config_list;
    }

    /**
     * 获取配置值
     *
     * @return mixed
     */
    public function getValueByKey(string $key)
    {
        return $this->getList()->firstWhere('key', $key)['value'] ?? null;
    }

    /**
     * 获取配置
     *
     * @return mixed
     */
    public function getConfigByKey(string $key)
    {
        return $this->getList()->firstWhere('key', $key);
    }

    public function getListHash()
    {
        return \sha1($this->getList()->toJson());
    }

    public function getGroupsHash()
    {
        return \sha1($this->getGroups()->toJson());
    }
}
