<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\User\Models\UserYongjinLog;

#[SystemMenu('用户佣金日志', icon: 'fas fa-money-bill-wave', parent_code: 'system.user.manager')]
class UserYongjinLogController extends AbstractCrudController
{
    protected function getModel()
    {
        return new UserYongjinLog;
    }

    protected function with(): array
    {
        return ['user'];
    }
}
