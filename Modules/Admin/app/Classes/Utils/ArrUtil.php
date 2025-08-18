<?php

namespace Modules\Admin\Classes\Utils;

class ArrUtil
{
    private function __construct() {}

    /**
     * 数组转换为树结构
     *
     * @param  mixed $items        原始数组
     * @param  mixed $for_key      用于关联的键名
     * @param  mixed $local_key    本地键名
     * @param  mixed $sub_coll_key 子集合键名
     * @return array 转换后的树结构数组
     */
    public static function convertToTree(mixed $items, $for_key, $local_key, $sub_coll_key): array
    {
        // 首先将数组转换为以 code 为键的关联数组，便于快速查找
        $itemsByCode = [];
        foreach ($items as &$item) {
            $itemsByCode[$item[$local_key]] = &$item;
        }
        unset($item); // 释放引用，避免后续问题

        $rootItems = [];

        foreach ($items as $item) {
            $parentCode = $item[$for_key];

            // 如果找不到父节点或者父节点是当前节点自身，则作为根节点
            if (! isset($itemsByCode[$parentCode]) || $parentCode === $item[$local_key]) {
                $rootItems[] = &$itemsByCode[$item[$local_key]];
            } else {
                $itemsByCode[$parentCode][$sub_coll_key] ??= [];
                // 将当前节点添加到父节点的 children 中
                $itemsByCode[$parentCode][$sub_coll_key][] = &$itemsByCode[$item[$local_key]];
            }
        }
        unset($item); // 释放引用

        return $rootItems;
    }

    /**
     * 递归过滤数组
     *
     * @param string $children_key
     */
    public static function recursiveFilter(array $items, callable $callback, $children_key = 'children'): array
    {
        $result = [];
        foreach ($items as $item) {
            if ($callback($item)) {
                $result[] = $item;
            }
            if (isset($item[$children_key])) {
                $item[$children_key] = self::recursiveFilter($item[$children_key], $callback, $children_key);
            }
        }

        return $result;
    }
}
