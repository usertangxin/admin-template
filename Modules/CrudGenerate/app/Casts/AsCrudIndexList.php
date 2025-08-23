<?php

namespace Modules\CrudGenerate\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsCrudIndexList implements CastsAttributes
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
                'type'           => $item['type'], // 字段类型
                'field'          => $item['field'], // 字段名
                'nullable'       => (bool) $item['nullable'], // 是否可空
                'comment'        => $item['comment'], // 注释
                'special_params' => $item['special_params'], // 特有参数
            ];
        }

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
