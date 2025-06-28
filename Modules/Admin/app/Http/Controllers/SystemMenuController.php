<?php

namespace Modules\Admin\Http\Controllers;

use Artisan;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Classes\Utils\SystemMenuType;

class SystemMenuController extends AbstractController
{
    #[SystemMenu('系统菜单', type: SystemMenuType::MENU, parent_code: 'system.permission')]
    public function index()
    {
        return $this->success([
            'tree' => SystemMenuRegisterService::getSystemMenuTree(),
            'list' => SystemMenuRegisterService::getSystemMenuList(),
        ]);
    }

    #[SystemMenu('刷新系统菜单缓存')]
    public function getRefreshSystemMenuCache()
    {
        $route_cache_file = app()->getCachedRoutesPath();
        if (\file_exists($route_cache_file)) {
            Artisan::call('route:cache');
        }
        $system_menus = SystemMenuRegisterService::getOriginSystemMenu();
        $tree = ArrUtil::convertToTree($system_menus, 'parent_code', 'code', 'children');
        if ($system_menus) {
            SystemMenuRegisterService::writeMenuTreeToCacheFile($tree);
            SystemMenuRegisterService::writeMenuToCacheFile($system_menus);
        }

        return $this->success();
    }

    #[SystemMenu('删除系统菜单缓存')]
    public function deleteCache()
    {
        SystemMenuRegisterService::deleteCacheFile();

        return $this->success();
    }
}
