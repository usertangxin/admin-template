<?php

namespace Modules\User\Classes;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuManager;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Nwidart\Modules\Module;

class AdminScript implements AdminScriptInterface
{
    public function enable(Module $module)
    {
        app(SystemMenuManager::class)->autoRegister(
            new SystemMenu(
                name: '用户管理',
                type: SystemMenuType::GROUP,
                icon: 'fas fa-users',
                code: 'system.user.manager',
                name_lang: 'user::system_menu.user_manager'
            )
        );
    }

    public function disable(Module $module)
    {
        // TODO: Implement disable() method.
    }

    public function delete(Module $module)
    {
        // TODO: Implement delete() method.
    }
}
