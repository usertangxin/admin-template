<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SystemAdminRole extends Pivot
{
    use HasUuids;
    
    protected $table = 'system_admin_roles';

    public $incrementing = true;

    public $timestamps = false;
}
