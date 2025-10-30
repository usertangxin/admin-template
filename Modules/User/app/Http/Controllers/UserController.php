<?php

namespace Modules\User\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractCrudController;
use Modules\User\Models\User;

#[SystemMenu('用户管理', icon: 'fas fa-users')]
class UserController extends AbstractCrudController
{
    protected function getModel()
    {
        return new User;
    }
}
