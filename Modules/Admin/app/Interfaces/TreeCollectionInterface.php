<?php

namespace Modules\Admin\Interfaces;

interface TreeCollectionInterface
{
    public function toTree(): static;

    public static function new(): static;
}
