<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Facades\Artisan;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Nwidart\Modules\Module;

class AdminScript implements AdminScriptInterface
{
    public function enable(Module $module)
    {
        Artisan::call('module:seed', ['module' => 'CrudGenerate']);
    }

    public function disable(Module $module)
    {
        //
    }

    public function delete(Module $module)
    {
        //
    }
}
