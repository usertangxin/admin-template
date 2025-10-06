<?php

namespace Modules\Admin\Models\Scopes;

use Exception;
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

            /** @var GlobalDataPermissionScope|null $scope */
            $scope = null;

            if (method_exists($model, 'getGlobalDataPermissionScope')) {
                $scope = $model->getGlobalDataPermissionScope();
            }

            if (is_null($scope)) {
                $service = app(GlobalDataPermissionScopeService::class);
                $scope   = $service->get(Auth::user()->data_scope_name);
            }

            if (is_null($scope)) {
                throw new Exception('Global data permission scope not found');
            }

            $scope->apply($builder, $model);
        }
    }
}
