<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\RouteUtil;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\UserVipLevelController;

Route::middleware([AdminSupport::class])->group(function () {
    RouteUtil::fastRoute(UserController::class);
    RouteUtil::fastRoute(UserVipLevelController::class);
});
