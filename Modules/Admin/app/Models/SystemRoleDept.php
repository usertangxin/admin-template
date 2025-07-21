<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemRoleDeptFactory;

class SystemRoleDept extends Pivot
{
    protected $table = 'system_role_depts';

    public $incrementing = true;

    public $timestamps = false;
}
