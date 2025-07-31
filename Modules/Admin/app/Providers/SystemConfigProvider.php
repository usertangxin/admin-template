<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Classes\Service\SystemConfigService;

class SystemConfigProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();
        $this->app->singleton(SystemConfigService::class, function (Application $application) {
            return new SystemConfigService;
        });
    }

    public function boot(SystemConfigService $systemConfigService): void
    {
        app(SystemConfigService::class)->registerGroupQueue(function () {
            return \config('admin.system_config_group');
        });
        app(SystemConfigService::class)->registerListQueue(function () {
            $system_config_agreement = \config('admin.system_config_agreement');
            $system_config_email     = \config('admin.system_config_email');
            $system_config_map       = \config('admin.system_config_map');
            $system_config_site      = \config('admin.system_config_site');
            $system_config_upload    = \config('admin.system_config_upload');
            $system_config_wechat    = \config('admin.system_config_wechat');

            return array_merge($system_config_agreement, $system_config_email, $system_config_map, $system_config_site, $system_config_upload, $system_config_wechat);
        })->registerModifyConfigQueue(function ($configList, SystemConfigService $systemConfigService) {
            $config_select_data = [
                ['label' => '阿里云OSS', 'value' => 'oss'],
                ['label' => '七牛云',    'value' => 'qiniu'],
                ['label' => '腾讯云COS', 'value' => 'cos'],
                ['label' => '亚马逊S3',  'value' => 's3'],
            ];
            $config                       = $systemConfigService->getConfigByKey('storage_mode');
            $config['config_select_data'] = array_merge($config['config_select_data'], $config_select_data);
            $systemConfigService->setConfigByKey('storage_mode', $config);
        });
        app()->booted(function () use ($systemConfigService) {
            $systemConfigService->bootRegister();
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
