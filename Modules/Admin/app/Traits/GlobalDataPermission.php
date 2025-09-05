<?php

namespace Modules\Admin\Traits;

use Modules\Admin\Models\Scopes\GlobalDataPermissionScope;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait GlobalDataPermission
{
    public static function bootGlobalDataPermission()
    {
        static::addGlobalScope(GlobalDataPermissionScope::class);
    }

    /**
     * 禁用全局数据权限
     *
     * @return mixed
     */
    public static function withoutGlobalDataPermissionScope()
    {
        return static::withoutGlobalScope(GlobalDataPermissionScope::class);
    }
}
