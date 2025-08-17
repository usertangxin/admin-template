<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Services\SystemPermissionService;

class DashboardController extends AbstractController
{
    public function main()
    {
        return $this->inertia(
            [
                'system_menus_tree' => SystemPermissionService::getInstance()->getSystemMenuTree(),
                'system_menus_list' => SystemPermissionService::getInstance()->getSystemMenuList(),
                'auth'              => Auth::user(),
            ],
            view: 'main'
        );
    }
}
