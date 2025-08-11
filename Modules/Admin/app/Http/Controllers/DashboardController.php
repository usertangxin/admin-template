<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Services\SystemMenuService;

class DashboardController extends AbstractController
{
    public function main()
    {
        return $this->inertia(
            [
                'system_menus_tree' => SystemMenuService::getInstance()->getSystemMenuTree(),
                'system_menus_list' => SystemMenuService::getInstance()->getSystemMenuList(),
                'auth'              => Auth::user(),
            ],
            view: 'main'
        );
    }
}
