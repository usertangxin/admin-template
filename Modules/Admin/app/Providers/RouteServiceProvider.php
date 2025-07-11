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
            SystemMenuRegisterService::pushSystemMenu(new SystemMenu('OpenApi', url: 'docs/api', type: SystemMenuType::MENU, code: 'scramble.docs.ui', icon: 'fas fa-code'));
            SystemMenuRegisterService::pushSystemMenu(new SystemMenu('百度IFrame', url: 'https://www.baidu.com', type: SystemMenuType::IFRAME, code: 'baidu.com', icon: 'fas fa-link'));
            SystemMenuRegisterService::pushSystemMenu(new SystemMenu('百度外链', url: 'https://www.baidu.com', type: SystemMenuType::LINK, code: 'link.baidu.com', icon: 'fas fa-link'));
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->prefix('web/module/' . $this->name)->name('web.module.' . $this->name . '.')->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api/module/' . $this->name)->name('api.module.' . $this->name . '.')->group(module_path($this->name, '/routes/api.php'));
    }
}
