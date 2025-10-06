<?php

namespace Modules\Admin\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Services\GlobalDataPermissionScopeService;

class GlobalDataPermissionScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if ($model->ignoreGlobalDataPermission) {
            return;
        }
        if (Auth::user()) {
            if (Auth::user()->is_root) {
                return;
            }
            $service = app(GlobalDataPermissionScopeService::class);
            $service->get(Auth::user()->data_scope_name)->apply($builder, $model);
        }
    }
}
