<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemMenu extends AbstractModel
{
    use HasUuids;

    protected $table = 'system_menus';

    protected function casts()
    {
        return [
            'is_hidden'       => 'boolean',
            'is_auto_collect' => 'boolean',
            'allow_all'       => 'boolean',
        ];
    }
}
