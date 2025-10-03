<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ModelUtil
{
    private function __construct() {}

    /**
     * 搜索
     * 可以使用本地查询范围来定义搜索条件
     *
     * @param  Builder|Model $query
     * @return Builder
     */
    public static function bindSearch($query, $where)
    {
        $all_fields = Schema::getColumnListing($query->getModel()->getTable());
        foreach ($where as $key => $value) {
            if ($query->hasNamedScope($key)) {
                // 如果存在本地查询范围，则调用该范围
                $query = $query->{$key}($value);
            } else {
                // 否则使用直接的字段查询
                if (in_array($key, $all_fields)) {
                    $query = $query->where($key, $value);
                }
            }
        }

        return $query;
    }
}
