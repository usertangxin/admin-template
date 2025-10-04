<?php

namespace Modules\CrudGenerate\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsCrudFieldList implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        $data = json_decode($value, true);

        return collect($data)->map(function ($item) {
            $a = [
                ...$item,
            ];

            // 防止空对象被序列化为数组
            if (! $item['field_control_special_params']) {
                $a['field_control_special_params'] = [
                    '_______' => '_______',
                ];
            }

            if (! $item['page_view_control_special_params']) {
                $a['page_view_control_special_params'] = [
                    '_______' => '_______',
                ];
            }

            if (! $item['page_view_control_query_params']) {
                $a['page_view_control_query_params'] = [
                    '_______' => '_______',
                ];
            }

            return $a;
        })->toArray();
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        $data = [];
        foreach ($value as $item) {
            $data[] = [
                'field_control'                    => $item['field_control'], // 字段类型
                'field_control_special_params'     => (object) $item['field_control_special_params'], // 特有参数
                'field_name'                       => $item['field_name'], // 字段名
                'default_value'                    => $item['default_value'], // 默认值
                'nullable'                         => $item['nullable'], // 是否可空
                'comment'                          => $item['comment'], // 注释
                'gen_form'                         => $item['gen_form'], // 是否生成表到单页面
                'gen_index'                        => $item['gen_index'], // 是否生成到列表页面
                'gen_query'                        => $item['gen_query'], // 是否生成到查询区域
                'gen_sort'                         => $item['gen_sort'], // 是否参与排序
                'page_view_control'                => $item['page_view_control'], // 页面控件
                'page_view_control_special_params' => (object) $item['page_view_control_special_params'], // 特有参数
                'page_view_control_query_params'   => (object) $item['page_view_control_query_params'], // 查询参数
            ];
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
