<?php

namespace Modules\Admin\Traits;

use Modules\Admin\Models\Scopes\GlobalDataPermissionScope;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait GlobalDataPermission
{
    public bool $globalDataPermission = true;

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

    /**
     * 启用全局数据权限
     *
     * @return $this
     */
    public function enableGlobalDataPermission()
    {
        $this->globalDataPermission = true;

        return $this;
    }

    /**
     * 禁用全局数据权限
     *
     * @return $this
     */
    public function disableGlobalDataPermission()
    {
        $this->globalDataPermission = false;

        return $this;
    }
}
