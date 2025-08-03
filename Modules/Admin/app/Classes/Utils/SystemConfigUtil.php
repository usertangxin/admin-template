<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Support\Arr;
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

    public static function autoUpdateConfig(mixed $value, \Closure $closure)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            $model = SystemConfig::where('key', $item['key'])->firstOr();
            if ($model) {
                $closure($model, $item);
            }
        }
    }

    public static function autoEnableConfig(mixed $value)
    {
        static::autoUpdateConfig($value, function ($model, $item) {
            $input_attr             = $model->input_attr;
            $input_attr['disabled'] = false;
            $model->input_attr      = $input_attr;
            $model->save();
        });
    }

    public static function autoDisableConfig(mixed $value)
    {
        static::autoUpdateConfig($value, function ($model, $item) {
            $input_attr             = $model->input_attr;
            $input_attr['disabled'] = true;
            $model->input_attr      = $input_attr;
            $model->save();
        });
    }

    public static function configSelectDataSave($config_key, $select_data)
    {
        $a = SystemConfig::where('key', $config_key)->first();
        if ($a) {
            $data_config_select_data = $a->config_select_data;
            $data_config_select_data = array_merge($data_config_select_data, $select_data);
            $merged                  = Arr::keyBy($data_config_select_data, 'value');
            foreach ($select_data as $item) {
                $merged[$item['value']] = $item;
            }
            $merged                = array_values($merged);
            $a->config_select_data = $merged;
            $a->save();
        }
    }

    public static function configSelectDataRemove($config_key, $select_data)
    {
        $a = SystemConfig::where('key', $config_key)->first();
        if ($a) {
            $data_config_select_data = $a->config_select_data;
            $excludeValues           = Arr::pluck($select_data, 'value');
            $filtered                = Arr::where($data_config_select_data, function ($item) use ($excludeValues) {
                return ! in_array($item['value'], $excludeValues);
            });
            $a->config_select_data = $filtered;
            $a->save();
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
