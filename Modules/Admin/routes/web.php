<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Admin\Classes\Service\ResponseService;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;
use Modules\Admin\Http\Controllers\CrudTestController;
use Modules\Admin\Http\Controllers\LoginController;
use Modules\Admin\Http\Controllers\SystemAdminController;
use Modules\Admin\Http\Controllers\SystemConfigController;
use Modules\Admin\Http\Controllers\SystemDictController;
use Modules\Admin\Http\Controllers\SystemMenuController;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\Admin\Http\Middleware\HandleInertiaRequests;
use Modules\Admin\Http\Middleware\HandleInertiaShare;

Route::middleware([HandleInertiaRequests::class, AdminSupport::class])->group(function () {

    Route::get('login', [LoginController::class, 'view'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth:admin', HandleInertiaShare::class])->group(function () {
        Route::get('', function () {
            return Inertia::render('main', [
                'system_menus_tree' => SystemMenuRegisterService::getInstance()->getSystemMenuTree(),
                'system_menus_list' => SystemMenuRegisterService::getInstance()->getSystemMenuList(),
                'auth'              => Auth::user(),
            ]);
        })->name('index');
        Route::post('clear-system-cache', function(){
            Cache::clear();
            return ResponseService::success(message: '清理系统缓存成功');
        })->name('clear-system-cache');
        SystemMenuRegisterService::getInstance()->fastRoute(SystemConfigController::class);
        SystemMenuRegisterService::getInstance()->fastRoute(SystemDictController::class);
        SystemMenuRegisterService::getInstance()->fastRoute(SystemMenuController::class);
        SystemMenuRegisterService::getInstance()->fastRoute(SystemAdminController::class);

        if (app()->isLocal() || app()->runningUnitTests()) {
            SystemMenuRegisterService::getInstance()->fastRoute(CrudTestController::class);
        }
    });
});
