<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Classes\Utils\SystemConfigUtil;
use function config;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group_arr = config('admin.system_config_group');
        SystemConfigUtil::autoResisterGroup($group_arr);

        $system_config_agreement = config('admin.system_config_agreement');
        $system_config_email     = config('admin.system_config_email');
        $system_config_map       = config('admin.system_config_map');
        $system_config_site      = config('admin.system_config_site');
        $system_config_upload    = config('admin.system_config_upload');
        $system_config_wechat    = config('admin.system_config_wechat');

        $config_arr = array_merge($system_config_agreement, $system_config_email, $system_config_map, $system_config_site, $system_config_upload, $system_config_wechat);
        SystemConfigUtil::autoResisterConfig($config_arr);
    }
}
