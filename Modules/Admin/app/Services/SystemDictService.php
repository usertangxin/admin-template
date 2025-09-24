<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;

/**
 * 系统字典服务
 * 请从容器中获取实例
 */
class SystemDictService
{
    protected Collection $group;

    protected Collection $list;

    /**
     * 获取字典服务实例
     *
     * @throws BindingResolutionException
     */
    public static function getInstance(): static
    {
        return app(self::class);
    }

    /**
     * 获取字典组
     */
    public function getGroups(): Collection
    {
        $this->group ??= collect(Cache::remember(config('admin.cache_name_map.system_dict_group_list'), 60 * 60 * 24, function () {
            return SystemDictType::all();
        }));

        return $this->group;
    }

    /**
     * 获取字典列表
     */
    public function getList(): Collection
    {
        $this->list ??= collect(Cache::remember(config('admin.cache_name_map.system_dict_list'), 60 * 60 * 24, function () {
            return SystemDict::all();
        }));

        return $this->list;
    }

    /**
     * 根据字典组编码获取字典值集合
     *
     * @param  mixed                         $code
     * @return Collection<string|int, mixed>
     */
    public function getValuesByCode($code)
    {
        return $this->getList()->where('code', $code)->pluck('value');
    }

    /**
     * 根据字典组编码获取字典集合
     *
     * @param  mixed      $code
     * @return Collection
     */
    public function getListByCode($code)
    {
        return $this->getList()->where('code', $code);
    }

    /**
     * 获取字典列表哈希值
     *
     * @return string
     */
    public function getListHash()
    {
        return \sha1($this->getList()->toJson());
    }

    /**
     * 获取字典组哈希值
     *
     * @return string
     */
    public function getGroupsHash()
    {
        return \sha1($this->getGroups()->toJson());
    }
}
