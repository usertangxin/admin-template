<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelUtil
{
    private function __construct() {}

    /**
     * 搜索
     * 可以使用scope开头的方法来定义搜索条件
     *
     * @param  Builder|Model $query
     * @param  array         $where
     * @return Builder
     */
    public static function bindSearch($query, $where)
    {
        foreach ($where as $key => $value) {
            if ($query->hasNamedScope($key)) {
                $query = $query->callNamedScope($key, $value);

                continue;
            }
            $query = $query->where($key, $value);
        }

        return $query;
    }
}
