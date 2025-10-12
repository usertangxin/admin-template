<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Support\Facades\Lang;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;

class SystemDictUtil
{
    private function __construct() {}

    public static function autoRegisterTypes($value, $lang_prefix = '')
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemDictType::whereCode($item['code'])->firstOr(function () use ($item, $lang_prefix) {
                $data = [
                    'name'   => [],
                    'code'   => $item['code'],
                    'remark' => [],
                ];
                foreach (config('admin.multi_language') as $lang) {
                    if (Lang::has($lang_prefix . $item['code'] . '.name', $lang)) {
                        $data['name'][$lang] = __($lang_prefix . $item['code'] . '.name', locale: $lang);
                    } else {
                        $data['name'][$lang] = $item['name'];
                    }
                    if (Lang::has($lang_prefix . $item['code'] . '.remark', $lang)) {
                        $data['remark'][$lang] = __($lang_prefix . $item['code'] . '.remark', locale: $lang);
                    } else {
                        $data['remark'][$lang] = $item['remark'];
                    }
                }
                SystemDictType::create($data);
            });
        }
    }

    public static function autoRegisterDicts($value, $lang_prefix = '')
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
