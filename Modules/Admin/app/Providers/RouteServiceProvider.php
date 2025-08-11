<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Admin\Services\SystemMenuService;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Admin';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    public function register()
    {
        parent::register();
        $this->app->singleton(SystemMenuService::class, function () {
            return new SystemMenuService;
        });
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->prefix('web/' . Str::kebab($this->name))->name('web.' . Str::kebab($this->name) . '.')->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api/' . Str::kebab($this->name))->name('api.' . Str::kebab($this->name) . '.')->group(module_path($this->name, '/routes/api.php'));
    }
}
