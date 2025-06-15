<?php

namespace Modules\Admin\Models;

class SystemDept extends SoftDelModel
{
    protected $table = 'system_dept';

    public function leader()
    {
        return $this->belongsToMany(SystemUser::class, foreignPivotKey: 'user_id', relatedPivotKey: 'dept_id')->using(SystemDeptLeader::class);
    }
}
