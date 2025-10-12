<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Support\Facades\Lang;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;

class SystemDictUtil
{
    private function __construct() {}

    public static function autoRegisterTypes($value)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemDictType::whereCode($item['code'])->firstOr(function () use ($item) {
                $data = [
                    'name'   => $item['name'],
                    'code'   => $item['code'],
                    'remark' => $item['remark'],
                ];
                SystemDictType::create($data);
            });
        }
    }

    public static function autoRegisterDicts($value)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemDict::whereCode($item['code'])->whereValue($item['value'])->firstOr(function () use ($item) {
                $data = [
                    'label' => $item['label'],
                    'remark' => $item['remark'],
                    'color'  => $item['color'] ?? null,
                    'value'  => $item['value'],
                    'code'   => $item['code'],
                ];
                SystemDict::create($data);
            });
        }
    }

    public static function autoUnregisterDicts(mixed $value)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemDict::whereCode($item['code'])->whereValue($item['value'])->delete();
        }
    }

    public static function autoDictsUpdate(mixed $value, \Closure $closure)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            $model = SystemDict::whereCode($item['code'])->whereValue($item['value'])->first();
            if ($model) {
                $closure($model, $item);
            }
        }
    }

    public static function autoEnableDicts(mixed $value)
    {
        self::autoDictsUpdate($value, function ($model, $item) {
            $model->status = 'normal';
            $model->save();
        });
    }

    public static function autoDisableDicts(mixed $value)
    {
        self::autoDictsUpdate($value, function ($model, $item) {
            $model->status = 'disabled';
            $model->save();
        });
    }
}
