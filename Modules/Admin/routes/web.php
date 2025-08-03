<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\RouteUtil;
use Modules\Admin\Http\Controllers\CrudTestController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\LoginController;
use Modules\Admin\Http\Controllers\ModuleManagerController;
use Modules\Admin\Http\Controllers\SystemAdminController;
use Modules\Admin\Http\Controllers\SystemConfigController;
use Modules\Admin\Http\Controllers\SystemDictController;
use Modules\Admin\Http\Controllers\SystemMenuController;
use Modules\Admin\Http\Controllers\SystemUploadFileController;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\Admin\Http\Middleware\HandleInertiaRequests;
use Modules\Admin\Http\Middleware\HandleInertiaShare;
use Modules\Admin\Services\ResponseService;

Route::middleware([HandleInertiaRequests::class, AdminSupport::class])->group(function () {

    Route::get('login', [LoginController::class, 'view'])->name('login.view');
    Route::post('login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth:admin', HandleInertiaShare::class])->group(function () {
        Route::get('', [DashboardController::class, 'main'])->name('index');
        Route::post('clear-system-cache', function () {
            Cache::clear();

            return ResponseService::success(message: '清理系统缓存成功');
        })->name('clear-system-cache');
        RouteUtil::fastRoute(SystemConfigController::class);
        RouteUtil::fastRoute(SystemDictController::class);
        RouteUtil::fastRoute(SystemMenuController::class);
        RouteUtil::fastRoute(SystemAdminController::class);
        RouteUtil::fastRoute(SystemUploadFileController::class);
        RouteUtil::fastRoute(ModuleManagerController::class);

        if (app()->isLocal() || app()->runningUnitTests()) {
            RouteUtil::fastRoute(CrudTestController::class);
        }
    });
});
