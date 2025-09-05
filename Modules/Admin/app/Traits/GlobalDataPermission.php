<?php

namespace Modules\Admin\Traits;

use Modules\Admin\Models\Scopes\GlobalDataPermissionScope;

trait GlobalDataPermission
{
    public static function bootGlobalDataPermission()
    {
        static::addGlobalScope(GlobalDataPermissionScope::class);
    }
}
