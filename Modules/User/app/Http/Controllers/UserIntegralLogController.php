<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractReadController;
use Modules\User\Models\UserIntegralLog;

#[SystemMenu('用户积分日志', icon: 'fas fa-coins', parent_code: 'system.user.manager')]
class UserIntegralLogController extends AbstractReadController
{
    protected function getModel()
    {
        return new UserIntegralLog;
    }

    protected function with(): array
    {
        return ['user'];
    }
}
