<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Role;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Transformers\SystemRoleResource;

#[SystemMenu('角色管理', icon: 'fas fa-address-card', parent_code: 'system.permission')]
class SystemRoleController extends AbstractCrudController
{
    protected function getModel()
    {
        return new Role;
    }

    protected function getResource(): ?string
    {
        return SystemRoleResource::class;
    }

    protected function with(): array
    {
        return ['permissions'];
    }

    protected function afterCreate($model): void
    {
        $model->syncPermissions(\request()->input('permissions', []));
    }

    protected function afterUpdate($model): void
    {
        $model->syncPermissions(\request()->input('permissions', []));
    }
}
