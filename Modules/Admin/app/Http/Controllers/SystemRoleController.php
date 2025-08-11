<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Role;
use Modules\Admin\Classes\Attrs\SystemMenu;

#[SystemMenu('角色管理', icon: 'fas fa-address-card', parent_code: 'system.permission')]
class SystemRoleController extends AbstractCrudController
{
    protected function getModel()
    {
        return new Role;
    }
}
