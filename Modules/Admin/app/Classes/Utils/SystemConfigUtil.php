<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Support\Facades\Lang;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;

/**
 * 系统配置工具类，提供系统配置相关的自动注册、更新、启用、禁用等操作方法。
 */
class SystemConfigUtil
{
    /**
     * 私有化构造函数，防止实例化。
     */
    private function __construct() {}

    /**
     * 自动注册系统配置组。
     *
     * @param mixed $value 配置组数据，可以是单个配置组数组或配置组数组列表。
     */
    public static function autoResisterGroup(mixed $value, $lang_prefix = '')
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemConfigGroup::whereCode($item['code'])->firstOr(function () use ($item, $lang_prefix) {
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
                SystemConfigGroup::create($data);
            });
        }
    }

    /**
     * 自动注册系统配置。
     *
     * @param mixed $value 配置数据，可以是单个配置数组或配置数组列表。
     */
    public static function autoResisterConfig(mixed $value, $lang_prefix = '')
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            SystemConfig::where('key', $item['key'])->firstOr(function () use ($item, $lang_prefix) {
                $data = [
                    'group'         => $item['group'],
                    'key'           => $item['key'],
                    'input_type'    => $item['input_type'] ?? null,
                    'bind_p_config' => $item['bind_p_config'] ?? null,
                    'value'         => $item['value'] ?? null,
                    'name'          => [],
                    'remark'        => [],
                    'input_attr'    => [],
                ];

                // 需要进行语言翻译的字段列表
                $translatableFields = [
                    'name', 'remark', 'input_attr',
                ];

                foreach (config('admin.multi_language') as $lang) {
                    foreach ($translatableFields as $field) {
                        $translationKey      = $lang_prefix . $item['key'] . '.' . $field;
                        $data[$field][$lang] = Lang::has($translationKey, $lang)
                            ? __($translationKey, locale: $lang)
                            : ($item[$field] ?? null);
                    }
                }

                SystemConfig::create($data);
            });
        }
    }

    /**
     * 自动更新系统配置。
     *
     * @param mixed    $value   配置数据，可以是单个配置数组或配置数组列表。
     * @param \Closure $closure 用于更新配置模型的闭包函数。
     */
    public static function autoUpdateConfig(mixed $value, \Closure $closure)
    {
        $arr = [];
        if (! is_array($value) || ! isset($value[0])) {
            $arr[] = $value;
        } else {
            $arr = $value;
        }
        foreach ($arr as $item) {
            $model = SystemConfig::where('key', $item['key'])->first();
            if ($model) {
                $closure($model, $item);
            }
        }
    }

    /**
     * 自动启用系统配置。
     *
     * @param mixed $value 配置数据，可以是单个配置数组或配置数组列表。
     */
    public static function autoEnableConfig(mixed $value)
    {
        static::autoUpdateConfig($value, function ($model, $item) {
            foreach (config('admin.multi_language') as $lang) {
                $input_attr = $model->getTranslation('input_attr', $lang);
                if (! $input_attr) {
                    $input_attr = [];
                }
                $input_attr['disabled'] = false;
                $model->setTranslation('input_attr', $lang, $input_attr);
            }

            $model->save();
        });
    }

    /**
     * 自动禁用系统配置。
     *
     * @param mixed $value 配置数据，可以是单个配置数组或配置数组列表。
     */
    public static function autoDisableConfig(mixed $value)
    {
        static::autoUpdateConfig($value, function ($model, $item) {
            foreach (config('admin.multi_language') as $lang) {
                $input_attr = $model->getTranslation('input_attr', $lang);
                if (! $input_attr) {
                    $input_attr = [];
                }
                $input_attr['disabled'] = true;
                $model->setTranslation('input_attr', $lang, $input_attr);
            }
            $model->save();
        });
    }

    /**
     * 自动注销系统配置。
     *
     * @param mixed $value 配置数据，可以是单个配置键名或配置数组列表。
     */
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
