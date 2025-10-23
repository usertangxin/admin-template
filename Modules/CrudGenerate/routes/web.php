<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\RouteUtil;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\CrudGenerate\Http\Controllers\CrudGenerateController;

Route::middleware([AdminSupport::class])->group(function () {
    RouteUtil::fastRoute(CrudGenerateController::class);
});
