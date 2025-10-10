<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuManager;
use Modules\Admin\Classes\Utils\SystemMenuType;

class SystemMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $a = [
            new SystemMenu('系统主页', url: 'web/admin', type: SystemMenuType::ACTION, code: 'web.admin.index', is_hidden: true, allow_admin: true, name_lang: 'admin::system_menu.default_menus.index'),
            new SystemMenu('权限管理', type: SystemMenuType::GROUP, icon: 'fas user-lock', code: 'system.permission', name_lang: 'admin::system_menu.default_menus.permission'),
            new SystemMenu('常规管理', type: SystemMenuType::GROUP, icon: 'fas gears', code: 'system.basic', name_lang: 'admin::system_menu.default_menus.basic'),
            new SystemMenu('登录', type: SystemMenuType::MENU, code: 'system_admin.login', is_hidden: true, name_lang: 'admin::system_menu.default_menus.login'),
        ];

        if (app()->environment('local')) {
            $a[] = new SystemMenu('开发', type: SystemMenuType::GROUP, icon: 'fas fa-code', code: 'system.dev');
            $a[] = new SystemMenu('OpenApi', url: 'docs/api', type: SystemMenuType::MENU, icon: 'fas fa-code', code: 'scramble.docs.ui', parent_code: 'system.dev');
            $a[] = new SystemMenu('Telescope', url: 'telescope', type: SystemMenuType::MENU, icon: 'fas fa-microscope', code: 'laravel.telescope.view', parent_code: 'system.dev');
            $a[] = new SystemMenu('Font Awesome', url: 'https://fontawesome.com/search?ic=free', type: SystemMenuType::LINK, icon: 'fas fa-icons', code: 'fontawesome.com', parent_code: 'system.dev');
        }

        SystemMenuManager::autoRegister($a);

        $arr = SystemMenuManager::collection();
        SystemMenuManager::autoRegister($arr);
    }
}
