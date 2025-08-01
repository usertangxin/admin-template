<?php

namespace Modules\Admin\Classes\Utils;

use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;

class SystemConfigUtil
{
    public static function autoResisterGroup(mixed $value)
    {
        $arr = [];
        if (! is_array($value)) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemConfigGroup::whereCode($item['code'])->firstOr(function () use ($item) {
                SystemConfigGroup::create([
                    'name'   => $item['name'],
                    'code'   => $item['code'],
                    'remark' => $item['remark'],
                ]);
            });
        }
    }

    public static function autoResisterConfig(mixed $value)
    {
        $arr = [];
        if (! is_array($value)) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {

            SystemConfig::where('key', $item['key'])->firstOr(function () use ($item) {
                SystemConfig::create([
                    'group'              => $item['group'],
                    'name'               => $item['name'],
                    'key'                => $item['key'],
                    'value'              => $item['value'] ?? null,
                    'input_type'         => $item['input_type'] ?? null,
                    'config_select_data' => $item['config_select_data'] ?? null,
                    'remark'             => $item['remark'] ?? null,
                    'bind_p_config'      => $item['bind_p_config'] ?? null,
                    'input_attr'         => $item['input_attr'] ?? null,
                ]);
            });
        }
    }

    public static function autoUnregisterConfig(mixed $value)
    {
        $arr = [];
        if (! is_array($value)) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemConfig::where('key', is_string($item) ? $item : $item['key'])->delete();
        }
    }
}
