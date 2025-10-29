<?php

namespace Modules\Sms\Classes;

use Modules\Admin\Classes\Utils\SystemConfigUtil;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Nwidart\Modules\Module;

class AdminScript implements AdminScriptInterface
{
    public function enable(Module $module)
    {
        $group_arr = config('sms.system_config_group');
        SystemConfigUtil::autoResisterGroup($group_arr);

        $system_config_map = config('sms.system_config_sms');
        SystemConfigUtil::autoResisterConfig($system_config_map);
    }

    public function disable(Module $module)
    {
        //
    }

    public function delete(Module $module)
    {
        $system_config_map = config('sms.system_config_sms');
        SystemConfigUtil::autoUnregisterConfig($system_config_map);

        $group_arr = config('sms.system_config_group');
        SystemConfigUtil::autoUnregisterGroup($group_arr);
    }
}
