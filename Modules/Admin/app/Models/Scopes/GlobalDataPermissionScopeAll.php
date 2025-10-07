<?php

namespace Modules\Admin\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\Admin\Interfaces\GlobalDataPermissionScopeInterface;

class GlobalDataPermissionScopeAll implements GlobalDataPermissionScopeInterface
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void {}

    public function getScopeName()
    {
        return 'all';
    }

    public function getExtendDataScopeViewName()
    {
        return null;
    }

    public function handleSyncExtendDataScope($data) {}
}
