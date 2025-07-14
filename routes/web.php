<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Models\SystemConfigGroup;

Route::get('/', function () {
    return Inertia::render('test');
});
