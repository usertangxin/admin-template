<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Middleware\HandleInertiaRequests;

// Route::middleware([])->group(function () {
//     Route::resource('admins', AdminController::class)->names('admin');
// });

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('test', function () {
        return Inertia::render('test', ['dd' => route('module.Admin.web.test')]);
    })->name('test');
    Route::get('test2', function () {
        return Inertia::render('test2', ['dd' => route('module.Admin.web.test')]);
    })->name('test2');
});
