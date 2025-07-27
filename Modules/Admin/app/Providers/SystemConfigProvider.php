<?php

namespace Modules\Admin\Providers;

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
        $this->app->singleton(SystemConfigService::class, function () {
            return new SystemConfigService;
        });
    }

    public function boot(SystemConfigService $systemConfigService): void
    {
        $systemConfigService->registerGroups(\config('admin.system_config_group'));
        $systemConfigService->registerList(\config('admin.system_config_agreement'));
        $systemConfigService->registerList(\config('admin.system_config_email'));
        $systemConfigService->registerList(\config('admin.system_config_map'));
        $systemConfigService->registerList(\config('admin.system_config_site'));
        $systemConfigService->registerList(\config('admin.system_config_upload'));
        $systemConfigService->registerList(\config('admin.system_config_wechat'));
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
