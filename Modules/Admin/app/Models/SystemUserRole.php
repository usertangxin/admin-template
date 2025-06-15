<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SystemUserRole extends Pivot
{
    protected $table = 'system_user_role';

    public $incrementing = true;

    public $timestamps = false;
}
