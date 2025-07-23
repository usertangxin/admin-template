<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Classes\Utils\SystemMenuType;

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
        $route_cache_file = app()->getCachedRoutesPath();
        if (\file_exists($route_cache_file)) {
            Artisan::call('route:cache');
        }
        $system_menus = SystemMenuRegisterService::getInstance()->getOriginSystemMenu();
        $tree = ArrUtil::convertToTree($system_menus, 'parent_code', 'code', 'children');
        if ($system_menus) {
            SystemMenuRegisterService::getInstance()->writeMenuTreeToCacheFile($tree);
            SystemMenuRegisterService::getInstance()->writeMenuToCacheFile($system_menus);
        }

        return $this->success(message: '刷新菜单缓存成功');
    }

    #[SystemMenu('删除系统菜单缓存')]
    public function deleteCache()
    {
        SystemMenuRegisterService::getInstance()->deleteCacheFile();

        return $this->success(message: '删除菜单缓存成功');
    }
}
