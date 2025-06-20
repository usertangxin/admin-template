<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\SystemConfigController;
use Modules\Admin\Http\Middleware\HandleInertiaRequests;

// Route::middleware([])->group(function () {
//     Route::resource('admins', AdminController::class)->names('admin');
// });

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('',function() {
        return Inertia::render('main');
    });
    Route::get('login', function () {
        return Inertia::render('login');
    })->name('login');

    SystemMenuRegisterService::fastRoute(SystemConfigController::class);

});
