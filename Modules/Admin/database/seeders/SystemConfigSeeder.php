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
        SystemConfigUtil::autoResisterGroup($group_arr, 'admin::system_config_group.');

        $system_config_agreement = config('admin.system_config_agreement');
        $system_config_email     = config('admin.system_config_email');
        $system_config_map       = config('admin.system_config_map');
        $system_config_site      = config('admin.system_config_site');
        $system_config_upload    = config('admin.system_config_upload');
        $system_config_wechat    = config('admin.system_config_wechat');

        SystemConfigUtil::autoResisterConfig($system_config_agreement, 'admin::system_config_agreement.');
        SystemConfigUtil::autoResisterConfig($system_config_email, 'admin::system_config_email.');
        SystemConfigUtil::autoResisterConfig($system_config_map, 'admin::system_config_map.');
        SystemConfigUtil::autoResisterConfig($system_config_site, 'admin::system_config_site.');
        SystemConfigUtil::autoResisterConfig($system_config_upload, 'admin::system_config_upload.');
        SystemConfigUtil::autoResisterConfig($system_config_wechat, 'admin::system_config_wechat.');
    }
}
