<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\SystemConfigController;
use Modules\Admin\Http\Controllers\SystemDictController;
use Modules\Admin\Http\Controllers\SystemMenuController;
use Modules\Admin\Http\Middleware\HandleInertiaRequests;
use Modules\Admin\Http\Middleware\HandleInertiaShare;

// Route::middleware([])->group(function () {
//     Route::resource('admins', AdminController::class)->names('admin');
// });

Route::middleware([HandleInertiaRequests::class, HandleInertiaShare::class])->group(function () {
    Route::get('', function () {
        return Inertia::render('main', [
            'system_menus_tree' => SystemMenuRegisterService::getSystemMenuTree(),
            'system_menus_list' => SystemMenuRegisterService::getSystemMenuList(),
        ]);
    });
    Route::get('login', function () {
        return Inertia::render('login');
    })->name('login');

    SystemMenuRegisterService::fastRoute(SystemConfigController::class);
    SystemMenuRegisterService::fastRoute(SystemDictController::class);
    SystemMenuRegisterService::fastRoute(SystemMenuController::class);
});
