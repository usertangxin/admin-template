<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemAdmin;
use Modules\Admin\Services\GlobalDataPermissionScopeService;
use Modules\Admin\Transformers\SystemAdminResource;

#[SystemMenu('系统管理员', icon: 'fas fa-user-tie', parent_code: 'system.permission')]
class SystemAdminController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null
    {
        return new SystemAdmin;
    }

    protected function getResource(): ?string
    {
        return SystemAdminResource::class;
    }

    protected function afterSave($model): void
    {
        $model->syncRoles(request()->input('roles', []));
        $service = app(GlobalDataPermissionScopeService::class);
        $service->get(request()->input('data_scope_name'))->handleSyncExtendDataScope(request()->input('extend_data_scope'));
    }

    #[SystemMenu('所有数据权限')]
    public function getDataScopes(GlobalDataPermissionScopeService $service)
    {
        return $this->success($service->toArray());
    }
}
