<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\RouteUtil;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\UserMoneyLogController;
use Modules\User\Http\Controllers\UserScoreLogController;
use Modules\User\Http\Controllers\UserVipLevelController;
use Modules\User\Http\Controllers\UserYongjinLogController;

Route::middleware([AdminSupport::class])->group(function () {
    RouteUtil::fastRoute(UserController::class);
    RouteUtil::fastRoute(UserVipLevelController::class);
    RouteUtil::fastRoute(UserYongjinLogController::class);
    RouteUtil::fastRoute(UserMoneyLogController::class);
    RouteUtil::fastRoute(UserScoreLogController::class);
});
