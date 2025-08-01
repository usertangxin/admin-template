<?php

namespace Modules\Admin\Classes\Utils;

use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;

class SystemConfigUtil
{
    private function __construct() {}

    public static function autoResisterGroup(mixed $value)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
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
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {

            SystemConfig::where('key', $item['key'])->firstOr(function () use ($item) {
                $model                     = new SystemConfig;
                $model->group              = $item['group'];
                $model->name               = $item['name'];
                $model->key                = $item['key'];
                $model->value              = $item['value'] ?? null;
                $model->input_type         = $item['input_type'] ?? null;
                $model->config_select_data = $item['config_select_data'] ?? null;
                $model->remark             = $item['remark'] ?? null;
                $model->bind_p_config      = $item['bind_p_config'] ?? null;
                $model->input_attr         = $item['input_attr'] ?? null;
                $model->save();
            });
        }
    }

    public static function autoUnregisterConfig(mixed $value)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemConfig::where('key', is_string($item) ? $item : $item['key'])->delete();
        }
    }
}
