<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\RouteUtil;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\User\Http\Controllers\UserBalanceLogController;
use Modules\User\Http\Controllers\UserCommissionLogController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\UserIntegralLogController;
use Modules\User\Http\Controllers\UserVipLevelController;

Route::middleware([AdminSupport::class])->group(function () {
    RouteUtil::fastRoute(UserController::class);
    RouteUtil::fastRoute(UserVipLevelController::class);
    RouteUtil::fastRoute(UserCommissionLogController::class);
    RouteUtil::fastRoute(UserBalanceLogController::class);
    RouteUtil::fastRoute(UserIntegralLogController::class);
});
