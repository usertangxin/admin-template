<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\User\Models\UserMoneyLog;

#[SystemMenu('用户余额日志', icon: 'fas fa-money-bill-wave', parent_code: 'system.user.manager')]
class UserMoneyLogController extends AbstractCrudController
{
    protected function getModel()
    {
        return new UserMoneyLog;
    }

    protected function with(): array
    {
        return ['user'];
    }
}