<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\RouteUtil;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\Admin\Http\Middleware\HandleInertiaRequests;
use Modules\Admin\Http\Middleware\HandleInertiaShare;
use Modules\CrudGenerate\Http\Controllers\CrudGenerateController;

Route::middleware([HandleInertiaRequests::class, AdminSupport::class, 'auth:admin', HandleInertiaShare::class])->group(function () {
    RouteUtil::fastRoute(CrudGenerateController::class);
});
