<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Services\SystemDictService;

class SystemDictProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();
        $this->app->singleton(SystemDictService::class, function () {
            return new SystemDictService;
        });
    }

    public function boot(SystemDictService $systemDictService): void {}

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
