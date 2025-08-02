<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Services\SystemMenuRegisterService;

class SystemMenuController extends AbstractController
{
    #[SystemMenu('菜单规则', type: SystemMenuType::MENU, parent_code: 'system.permission', icon: 'fas bars')]
    public function index()
    {
        return $this->success([
            'tree' => SystemMenuRegisterService::getInstance()->getSystemMenuTree(),
            'list' => array_values(SystemMenuRegisterService::getInstance()->getSystemMenuList()),
        ]);
    }

    #[SystemMenu('刷新系统菜单缓存')]
    public function putRefreshSystemMenuCache()
    {
        // TODO
        return $this->success(message: '刷新菜单缓存成功');
    }

    #[SystemMenu('删除系统菜单缓存')]
    public function deleteCache()
    {
        // TODO
        return $this->success(message: '删除菜单缓存成功');
    }
}
