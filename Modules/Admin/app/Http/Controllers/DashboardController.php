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
                'system_menus_tree' => SystemPermissionService::getInstance()->getMyPermissionTree(),
                'system_menus_list' => SystemPermissionService::getInstance()->getMyPermissionList(),
                'auth'              => Auth::user(),
            ],
            view: 'main'
        );
    }
}
