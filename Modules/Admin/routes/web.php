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
use Modules\Admin\Http\Controllers\SystemRoleController;
use Modules\Admin\Http\Controllers\SystemUploadFileController;
use Modules\Admin\Http\Controllers\UtilController;
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
        RouteUtil::fastRoute(SystemConfigController::class);
        RouteUtil::fastRoute(SystemDictController::class);
        RouteUtil::fastRoute(SystemMenuController::class);
        RouteUtil::fastRoute(SystemAdminController::class);
        RouteUtil::fastRoute(SystemRoleController::class);
        RouteUtil::fastRoute(SystemUploadFileController::class);
        RouteUtil::fastRoute(ModuleManagerController::class);
        RouteUtil::fastRoute(UtilController::class);

        if (app()->isLocal() || app()->runningUnitTests()) {
            RouteUtil::fastRoute(CrudTestController::class);
        }
    });
});
