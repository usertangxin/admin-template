<?php

namespace Modules\Admin\Classes\DataBase;

use Illuminate\Database\Eloquent\Collection;
use Modules\Admin\Interfaces\TreeCollectionInterface;
use Modules\Admin\Classes\Utils\ArrUtil;

class TreeCollection extends Collection implements TreeCollectionInterface
{
    public $for_key = 'parent_id';

    public $local_key = 'id';

    public $sub_coll_key = 'children';

    public function toTree(): static
    {
        $items       = $this->toArray();
        $tree        = ArrUtil::convertToTree($items, $this->for_key, $this->local_key, $this->sub_coll_key);
        $this->items = $tree;

        return $this;
    }

    public static function new(mixed $items = [], string $for_key = 'parent_id', string $local_key = 'id', string $sub_coll_key = 'children'): static
    {
        $tree               = new static($items);
        $tree->for_key      = $for_key;
        $tree->local_key    = $local_key;
        $tree->sub_coll_key = $sub_coll_key;

        return $tree;
    }
}
