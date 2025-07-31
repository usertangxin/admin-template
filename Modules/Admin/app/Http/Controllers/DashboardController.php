<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;

class DashboardController extends AbstractController
{
    public function main()
    {
        return $this->inertia(
            [
                'system_menus_tree' => SystemMenuRegisterService::getInstance()->getSystemMenuTree(),
                'system_menus_list' => SystemMenuRegisterService::getInstance()->getSystemMenuList(),
                'auth'              => Auth::user(),
            ],
            view: 'main'
        );
    }
}
