<?php

namespace Modules\Admin\Models;

class SystemRole extends AbstractSoftDelModel
{
    protected $table = 'system_role';

    public function depts()
    {
        return $this->belongsToMany(SystemDept::class, foreignPivotKey: 'role_id', relatedPivotKey: 'dept_id')->using(SystemRoleDept::class);
    }

    public function menus()
    {
        return $this->belongsToMany(SystemMenu::class, foreignPivotKey: 'role_id', relatedPivotKey: 'menu_id')->using(SystemRoleMenu::class);
    }
}
