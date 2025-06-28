<?php

namespace Modules\Admin\Classes\DataBase;

use Illuminate\Database\Eloquent\Collection;
use Modules\Admin\Classes\Utils\ArrUtil;

class TreeCollection extends Collection
{
    public function toTree()
    {
        $items = $this->items;
        $tree = ArrUtil::convertToTree($items, 'parent_id', 'id', 'children');
        $this->items = $tree;

        return $this;
    }

    public static function new(array $items = [])
    {
        return new static($items);
    }
}
