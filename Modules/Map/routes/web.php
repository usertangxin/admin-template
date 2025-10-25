<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\Map\Http\Controllers\IndexController;

Route::middleware([AdminSupport::class])->group(function () {
    Route::any('/_AMapService/{path}', [IndexController::class, 'amapServiceProxy'])->where('path', '.*')->name('amap-proxy');
    Route::get('/tencent-config', [IndexController::class, 'getTencentConfig'])->name('tencent-config');
    Route::get('/amap-config', [IndexController::class, 'getAmapConfig'])->name('amap-config');
});
