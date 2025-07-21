<?php

namespace Modules\Admin\Classes\Interfaces;

interface TreeCollectionInterface
{
    public function toTree(): static;

    public static function new(): static;
}
