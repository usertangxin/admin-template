<?php

namespace Modules\Admin\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Interfaces\GlobalDataPermissionScopeInterface;
use Modules\Admin\Models\Scopes\GlobalDataPermissionScope;
use Modules\Admin\Services\GlobalDataPermissionScopeService;

/**
 * @mixin Model
 */
trait GlobalDataPermission
{
    public bool $ignoreGlobalDataPermission = false;

    /**
     * 获取全局数据权限作用域，优先级高于设置的管理员全局数据权限
     *
     * @see GlobalDataPermissionScopeService
     * @see GlobalDataPermissionScope
     * @see GlobalDataPermissionScopeInterface
     *
     * @return GlobalDataPermissionScope|null
     */
    public function getGlobalDataPermissionScope(): ?GlobalDataPermissionScopeInterface
    {
        return null;
    }

    public static function bootGlobalDataPermission()
    {
        static::addGlobalScope(app(GlobalDataPermissionScope::class));
    }

    /**
     * 禁用全局数据权限
     *
     * @return mixed
     */
    public static function withoutGlobalDataPermissionScope()
    {
        return static::withoutGlobalScope(app(GlobalDataPermissionScope::class));
    }
}
