<?php

namespace Modules\Admin\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Interfaces\GlobalDataPermissionScopeInterface;

class GlobalDataPermissionScopeSelf implements GlobalDataPermissionScopeInterface
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('created_by', Auth::user()->id);
    }

    public function getScopeName()
    {
        return 'self';
    }

    public function getExtendDataScopeViewCodeFragment()
    {
        return null;
    }

    public function handleSyncExtendDataScope($data) {}
}
