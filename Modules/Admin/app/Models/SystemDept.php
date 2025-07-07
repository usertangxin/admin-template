<?php

namespace Modules\Admin\Models;

class SystemDept extends AbstractSoftDelModel
{
    protected $table = 'system_dept';

    public function leader()
    {
        return $this->belongsToMany(SystemAdmin::class, foreignPivotKey: 'admin_id', relatedPivotKey: 'dept_id')->using(SystemDeptLeader::class);
    }
}
