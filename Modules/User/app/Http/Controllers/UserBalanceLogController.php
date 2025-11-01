<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractReadController;
use Modules\User\Models\UserBalanceLog;

#[SystemMenu('用户余额日志', icon: 'fas fa-money-bill-wave', parent_code: 'system.user.manager')]
class UserBalanceLogController extends AbstractReadController
{
    protected function getModel()
    {
        return new UserBalanceLog;
    }

    protected function with(): array
    {
        return ['user'];
    }
}
