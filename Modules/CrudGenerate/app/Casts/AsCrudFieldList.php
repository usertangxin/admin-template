<?php

namespace Modules\CrudGenerate\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsCrudFieldList implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return json_decode($value, true);
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $data = [];
        foreach ($value as $item) {
            $data[] = [
                'field_control'                => $item['field_control'], // 字段类型
                'field_control_special_params' => $item['field_control_special_params'], // 特有参数
                'field_name'                   => $item['field_name'], // 字段名
                'default_value'                => $item['default_value'], // 默认值
                'nullable'                     => $item['nullable'] == 'yes', // 是否可空
                'comment'                      => $item['comment'], // 注释
                'gen_form'                     => $item['gen_form'] == 'yes', // 是否生成表到单页面
                'gen_index'                    => $item['gen_index'] == 'yes', // 是否生成到列表页面
                // 'gen_query'                         => $item['gen_query'] == 'yes', // 是否生成到查询区域
                'gen_sort'                          => $item['gen_sort'] == 'yes', // 是否参与排序
                'page_view_control'                 => $item['page_view_control'], // 页面控件
                'page_view_control_special_params'  => $item['page_view_control_special_params'], // 特有参数
                'query_view_control'                => $item['query_view_control'], // 查询控件
                'query_view_control_special_params' => $item['query_view_control_special_params'], // 特有参数
            ];
        }

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
