<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemDept extends AbstractSoftDelModel
{
    use HasUuids;

    protected $table = 'system_depts';

    public function leader()
    {
        return $this->belongsToMany(SystemAdmin::class, foreignPivotKey: 'admin_id', relatedPivotKey: 'dept_id')->using(SystemDeptLeader::class);
    }
}
