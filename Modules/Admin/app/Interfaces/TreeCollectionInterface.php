<?php

namespace Modules\Admin\Interfaces;

use ArrayAccess;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Support\Enumerable;

/**
 * 树集合接口
 *
 * @see Illuminate\Support\Collection
 */
interface TreeCollectionInterface extends ArrayAccess, CanBeEscapedWhenCastToString, Enumerable
{
    public function toTree(): static;

    public static function new($items): static;
}
