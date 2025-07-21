<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemDeptLeaderFactory;

class SystemDeptLeader extends Pivot
{
    protected $table = 'system_dept_leaders';

    public $incrementing = true;

    public $timestamps = false;
}
