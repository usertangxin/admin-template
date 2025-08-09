<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemRole extends AbstractSoftDelModel
{
    use HasUuids;
    
    protected $table = 'system_roles';

    public function depts()
    {
        return $this->belongsToMany(SystemDept::class, foreignPivotKey: 'role_id', relatedPivotKey: 'dept_id')->using(SystemRoleDept::class);
    }

    public function menus()
    {
        return $this->belongsToMany(SystemMenu::class, foreignPivotKey: 'role_id', relatedPivotKey: 'menu_id')->using(SystemRoleMenu::class);
    }
}
