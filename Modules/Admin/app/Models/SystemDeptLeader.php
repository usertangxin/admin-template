<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemDeptLeaderFactory;

class SystemDeptLeader extends Pivot
{
    protected $table = 'system_dept_leader';

    public $incrementing = true;

    public $timestamps = false;
}
