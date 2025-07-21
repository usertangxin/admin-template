<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemRoleMenuFactory;

class SystemRoleMenu extends Pivot
{
    protected $table = 'system_role_menus';

    public $incrementing = true;

    public $timestamps = false;

    protected function casts()
    {
        return [
            'action_fields_permissions' => 'json',
        ];
    }
}
