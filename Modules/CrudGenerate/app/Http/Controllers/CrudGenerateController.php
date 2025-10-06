<?php

namespace Modules\CrudGenerate\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Modules\CrudGenerate\Services\CrudGenerateService;
use Modules\CrudGenerate\Services\FieldControlService;
use Modules\CrudGenerate\Services\PageViewControlService;

#[SystemMenu('Crud生成', type: SystemMenuType::MENU, icon: 'fas trowel-bricks', parent_code: 'system.dev')]
class CrudGenerateController extends AbstractCrudController
{
    protected function getModel()
    {
        return new SystemCrudHistory;
    }

    #[SystemMenu('获取所有控件')]
    public function getControls(FieldControlService $field_control_service, PageViewControlService $page_view_control_service)
    {
        return $this->success([
            'field_controls'     => $field_control_service->jsonSerialize(),
            'page_view_controls' => $page_view_control_service->jsonSerialize(),
        ]);
    }

    #[SystemMenu('获取字段控件')]
    public function getFieldControls(FieldControlService $field_control_service)
    {
        return $this->success($field_control_service->jsonSerialize());
    }

    #[SystemMenu('获取页面控件')]
    public function getPageViewControls(PageViewControlService $page_view_control_service)
    {
        return $this->success($page_view_control_service->jsonSerialize());
    }

    #[SystemMenu('预览代码')]
    public function getPreviewCode(CrudGenerateService $service)
    {
        $id    = request('id');
        $model = $this->getModel()->find($id);

        return $this->success($service->fileContentMap($model));
    }

    #[SystemMenu('生成代码')]
    public function postGenerateCode(CrudGenerateService $service)
    {
        $id    = request('id');
        $model = $this->getModel()->find($id);
        $service->gen($model);

        return $this->success(message: '生成成功，确认迁移文件内容并运行迁移');
    }
}
