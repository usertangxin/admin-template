<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;
use Modules\Admin\Classes\Utils\SystemMenuType;

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

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapSystemMenuGroup();
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapSystemMenuGroup()
    {
        SystemMenuRegisterService::pushSystemMenu((new SystemMenu('权限管理', type: SystemMenuType::GROUP, code: 'system.permission', icon: 'fas drum-steelpan')));
        SystemMenuRegisterService::pushSystemMenu((new SystemMenu('常规管理', type: SystemMenuType::GROUP, code: 'system.setting', icon: 'fas gears')));
        if (\env('APP_ENV') === 'local') {
            SystemMenuRegisterService::pushSystemMenu(new SystemMenu('OpenApi', url: 'docs/api', type: SystemMenuType::MENU, code:'swagger.openapi' ,icon: 'fas fa-code'));
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->prefix('module/' . $this->name . '/web')->name('module.' . $this->name . '.web.')->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('module/' . $this->name . '/api')->name('module.' . $this->name . '.api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
