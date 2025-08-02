<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Services\SystemConfigService;

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

    public function boot(SystemConfigService $systemConfigService): void {}

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
