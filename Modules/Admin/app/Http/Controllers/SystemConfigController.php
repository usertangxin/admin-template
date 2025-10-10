<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Services\SystemConfigService;

class SystemConfigController extends AbstractController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel
    {
        return new SystemConfig;
    }

    #[SystemMenu('系统配置', type: SystemMenuType::MENU, icon: 'fas gear', parent_code: 'system.basic')]
    public function index(SystemConfigService $systemConfigService)
    {
        $data              = $systemConfigService->getList();
        $systemConfigGroup = $systemConfigService->getGroups();

        return $this->success([
            'config_list'       => $data,
            'config_group_list' => $systemConfigGroup,
        ]);
    }

    #[SystemMenu('修改系统配置')]
    public function postSave(SystemConfigService $systemConfigService)
    {
        $data = \request()->post('data');
        foreach ($data as $item) {
            $this->getModel()->updateOrCreate(['key' => $item['key']], $item);
        }

        $systemConfigService->refresh();

        return $this->success(message: '保存成功');
    }
}
