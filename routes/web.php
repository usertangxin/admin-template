<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;

Route::get('/', function () {
    $systemConfigGroup = new SystemConfigGroup();
    dump($systemConfigGroup->onlyTrashed());
    dump(ModelUtil::bindSearch(SystemConfigGroup::withTrashed(),['code'=>'site'])->get());
    return view('welcome');
});
