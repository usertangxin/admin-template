<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractReadController;
use Modules\User\Models\UserCommissionLog;

#[SystemMenu('用户佣金日志', icon: 'fas fa-money-bill-wave', parent_code: 'system.user.manager')]
class UserCommissionLogController extends AbstractReadController
{
    protected function getModel()
    {
        return new UserCommissionLog;
    }

    protected function with(): array
    {
        return ['user'];
    }
}
