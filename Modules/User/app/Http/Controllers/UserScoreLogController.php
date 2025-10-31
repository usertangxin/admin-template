<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\User\Models\UserScoreLog;

#[SystemMenu('用户积分日志', icon: 'fas fa-coins', parent_code: 'system.user.manager')]
class UserScoreLogController extends AbstractCrudController
{
    protected function getModel()
    {
        return new UserScoreLog;
    }

    protected function with(): array
    {
        return ['user'];
    }
}
