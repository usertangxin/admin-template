<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SystemAdminRole extends Pivot
{
    protected $table = 'system_admin_role';

    public $incrementing = true;

    public $timestamps = false;
}
