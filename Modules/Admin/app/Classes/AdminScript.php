<?php

namespace Modules\Admin\Classes;

use Artisan;
use Modules\Admin\Classes\Utils\SystemDictUtil;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Nwidart\Modules\Module;

class AdminScript implements AdminScriptInterface
{
    public function enable(Module $module)
    {
        Artisan::call('module:seed', ['module' => 'Admin']);

        $dict_groups = \config('admin.system_dict_type');

        SystemDictUtil::autoRegisterTypes($dict_groups);

        foreach ($dict_groups as $dict_group) {
            SystemDictUtil::autoRegisterDicts(\config('admin.dict.' . $dict_group['code']));
        }
    }

    public function disable(Module $module) {}

    public function delete(Module $module) {}
}
