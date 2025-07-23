<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Service\SystemDictService;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemDict;

class SystemDictController extends AbstractController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel
    {
        return new SystemDict;
    }

    #[SystemMenu('字典配置', type: SystemMenuType::MENU, parent_code: 'system.setting', icon: 'fas book')]
    public function index(SystemDictService $systemDictService)
    {
        $data = $systemDictService->getList();
        $groupList = $systemDictService->getGroups();

        return $this->success([
            'list'       => $data,
            'group_list' => $groupList,
        ]);
    }

    #[SystemMenu('修改字典配置')]
    public function postSave()
    {
        $data = \request()->post('data');
        // \dump($data);
        foreach ($data as $item) {
            $this->getModel()->updateOrCreate(['key' => $item['key']], $item);
        }

        return $this->success();
    }
}
