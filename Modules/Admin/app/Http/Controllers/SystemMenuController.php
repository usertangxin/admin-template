<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Collection;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuManager;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Models\SystemMenu as ModelsSystemMenu;
use Modules\Admin\Services\SystemPermissionService;

class SystemMenuController extends AbstractController
{
    #[SystemMenu('菜单规则', type: SystemMenuType::MENU, parent_code: 'system.permission', icon: 'fas bars')]
    public function index(SystemPermissionService $systemMenuRegisterService)
    {
        return $this->success([
            'tree' => $systemMenuRegisterService->getMyPermissionTree(),
            // 'list' => array_values($systemMenuRegisterService->getSystemMenuList()),
        ]);
    }

    #[SystemMenu('我的权限', allow_admin: true)]
    public function getMyPermissionTree(SystemPermissionService $systemMenuRegisterService)
    {
        $tree = $systemMenuRegisterService->getMyPermissionTree();

        return $this->success($tree);
    }

    #[SystemMenu('我的角色', allow_admin: true)]
    public function getMyRoles(SystemPermissionService $systemMenuRegisterService)
    {
        $roles = $systemMenuRegisterService->getMyRoles();

        return $this->success($roles);
    }

    #[SystemMenu('刷新系统菜单缓存')]
    public function putRefreshSystemMenuCache(SystemPermissionService $systemMenuRegisterService)
    {
        $menus = SystemMenuManager::collection();
        SystemMenuManager::autoRegister($menus);
        $new_collect_codes = (new Collection($menus))->pluck('code')->toArray();
        ModelsSystemMenu::where('is_auto_collect', true)->whereNotIn('code', $new_collect_codes)->delete();
        $systemMenuRegisterService->refresh();

        return $this->success(message: '刷新菜单缓存成功');
    }
}
