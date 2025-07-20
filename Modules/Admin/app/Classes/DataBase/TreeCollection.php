<?php

namespace Modules\Admin\Classes\DataBase;

use Illuminate\Database\Eloquent\Collection;
use Modules\Admin\Classes\Utils\ArrUtil;

class TreeCollection extends Collection
{
    public function toTree()
    {
        $items = $this->items;
        if (! \is_array($items)) {
            $items = $items->toArray();
        }
        $tree = ArrUtil::convertToTree($items, 'parent_id', 'id', 'children');
        $this->items = $tree;

        return $this;
    }

    public static function new(mixed $items = [])
    {
        return new static($items);
    }
}
