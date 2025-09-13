<?php

namespace Modules\Admin\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class GlobalDataPermissionScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        // TODO: 实现 apply() 方法.
        if ($model->ignoreGlobalDataPermission) {
            return;
        }
        if (Auth::user()) {
            if (Auth::user()->is_root) {
                return;
            }
        }
    }
}
