<?php

namespace Modules\CrudGenerate\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Modules\CrudGenerate\Services\FieldControlService;

#[SystemMenu('Crud生成', type: SystemMenuType::MENU, parent_code: 'system.dev', icon: 'fas trowel-bricks')]
class CrudGenerateController extends AbstractCrudController
{
    protected function getModel()
    {
        return new SystemCrudHistory;
    }

    #[SystemMenu('获取字段控件')]
    public function getFieldControls(FieldControlService $field_control_service)
    {
        return $this->success($field_control_service->jsonSerialize());
    }
}
