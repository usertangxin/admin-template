<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\User\Models\UserVipLevel;

#[SystemMenu('用户等级', icon: 'fas fa-user-graduate', parent_code: 'system.user.manager')]
class UserVipLevelController extends AbstractCrudController
{
    protected function getModel()
    {
        return new UserVipLevel;
    }
}
