<?php

namespace Modules\Admin\Classes;

use Artisan;
use Modules\Admin\Classes\Interfaces\AdminScriptInterface;

class AdminScript implements AdminScriptInterface
{
    public function install() {
        Artisan::call('module:seed', ['module' => 'Admin']);
    }

    public function uninstall() { }

}
