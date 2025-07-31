<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuManager;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Route;

class SystemMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $a = [
            new SystemMenu('权限管理', type: SystemMenuType::GROUP, code: 'system.permission', icon: 'fas drum-steelpan'),
            new SystemMenu('常规管理', type: SystemMenuType::GROUP, code: 'system.basic', icon: 'fas gears'),
        ];

        if (app()->environment('local')) {
            $a[] = new SystemMenu('开发', type: SystemMenuType::GROUP, code: 'system.dev', icon: 'fas fa-code');
            $a[] = new SystemMenu('OpenApi', url: 'docs/api', type: SystemMenuType::MENU, code: 'scramble.docs.ui', icon: 'fas fa-code', parent_code: 'system.dev');
            $a[] = new SystemMenu('Telescope', url: 'telescope', type: SystemMenuType::MENU, code: 'laravel.telescope.view', icon: 'fas fa-microscope', parent_code: 'system.dev');
            $a[] = new SystemMenu('Font Awesome', url: 'https://fontawesome.com/search?ic=free', type: SystemMenuType::LINK, code: 'fontawesome.com', icon: 'fas fa-icons', parent_code: 'system.dev');
        }

        SystemMenuManager::autoRegister($a);

        $arr = SystemMenuManager::collection();
        SystemMenuManager::autoRegister($arr);
    }
}
