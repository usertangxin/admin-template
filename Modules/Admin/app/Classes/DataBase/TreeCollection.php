<?php

namespace Modules\Admin\Classes\DataBase;
use Illuminate\Database\Eloquent\Collection;

class TreeCollection extends Collection
{
    public function toTree()
    {
        $items = $this->items;
        $grouped = [];
        foreach ($items as $item) {
            $grouped[$item->id] = $item;
            $grouped[$item->id]->children = [];
        }

        $tree = [];
        foreach ($grouped as $item) {
            if (isset($grouped[$item->parent_id])) {
                $grouped[$item->parent_id]->children[] = $item;
            } else {
                $tree[] = $item;
            }
        }

        $this->items = $tree;

        return $this;
    }
}
