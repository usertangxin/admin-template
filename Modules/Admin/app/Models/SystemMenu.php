<?php

namespace Modules\Admin\Models;

class SystemMenu extends AbstractModel
{
    protected $table = 'system_menus';

    protected function casts()
    {
        return [
            'is_hidden'       => 'boolean',
            'is_auto_collect' => 'boolean',
        ];
    }
}
