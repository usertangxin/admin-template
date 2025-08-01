<?php

namespace Modules\Admin\Classes\Utils;

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
                $model         = new SystemDictType;
                $model->name   = $item['name'];
                $model->code   = $item['code'];
                $model->remark = $item['remark'];
                $model->save();
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
                $model         = new SystemDict;
                $model->label  = $item['label'];
                $model->value  = $item['value'];
                $model->code   = $item['code'];
                $model->color  = $item['color'] ?? null;
                $model->remark = $item['remark'] ?? null;
                $model->save();
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
}
