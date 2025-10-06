<?php

namespace Modules\Admin\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Scopes\GlobalDataPermissionScope;

/**
 * @mixin Model
 */
trait GlobalDataPermission
{
    public bool $ignoreGlobalDataPermission = false;

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
