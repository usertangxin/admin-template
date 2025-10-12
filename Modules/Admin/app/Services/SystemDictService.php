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
     */
    public static function getInstance(): static
    {
        return app(self::class);
    }

    /**
     * 获取字典组
     */
    public function getGroups($locale = null): Collection
    {
        $locale ??= app()->getLocale();
        $this->group ??= collect(Cache::remember(config('admin.cache_name_map.system_dict_group_list') . $locale, 60 * 60 * 24, function () {
            return SystemDictType::all();
        }));

        return $this->group;
    }

    /**
     * 获取字典列表
     */
    public function getList($locale = null): Collection
    {
        $locale ??= app()->getLocale();
        $this->list ??= collect(Cache::remember(config('admin.cache_name_map.system_dict_list') . $locale, 60 * 60 * 24, function () {
            return SystemDict::all();
        }));

        return $this->list;
    }

    /**
     * 清除字典组缓存
     *
     * @param  mixed $locale
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function clearGroupCache($locale = null)
    {
        if ($locale) {
            Cache::forget(config('admin.cache_name_map.system_dict_group_list') . $locale);

            return;
        }
        $multi_language = config('admin.multi_language');
        foreach ($multi_language as $item) {
            Cache::forget(config('admin.cache_name_map.system_dict_group_list') . $item);
        }
    }

    /**
     * 清除字典列表缓存
     *
     * @param  mixed $locale
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function clearListCache($locale = null)
    {
        if ($locale) {
            Cache::forget(config('admin.cache_name_map.system_dict_list') . $locale);

            return;
        }
        $multi_language = config('admin.multi_language');
        foreach ($multi_language as $item) {
            Cache::forget(config('admin.cache_name_map.system_dict_list') . $item);
        }
    }

    /**
     * 根据字典组编码获取字典值集合
     *
     * @return Collection<string|int, mixed>
     */
    public function getValuesByCode(mixed $code, $locale = null): Collection
    {
        return $this->getList($locale)->where('code', $code)->pluck('value');
    }

    /**
     * 根据字典组编码获取字典集合
     */
    public function getListByCode(mixed $code, $locale = null): Collection
    {
        return $this->getList($locale)->where('code', $code);
    }

    /**
     * 获取字典列表哈希值
     */
    public function getListHash($locale = null): string
    {
        return \sha1($this->getList($locale)->toJson());
    }

    /**
     * 获取字典组哈希值
     */
    public function getGroupsHash($locale = null): string
    {
        return \sha1($this->getGroups($locale)->toJson());
    }
}
