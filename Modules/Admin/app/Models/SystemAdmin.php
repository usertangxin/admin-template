<?php

namespace Modules\Admin\Models;

// use Modules\Admin\Database\Factories\SystemadminFactory;

class SystemAdmin extends AbstractSoftDelModel
{
    protected $table = 'system_admin';

    protected function casts()
    {
        return [
            'backend_setting' => 'json',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(SystemRole::class, foreignPivotKey: 'role_id', relatedKey: 'admin_id')->using(SystemAdminRole::class);
    }

    public function posts()
    {
        return $this->belongsToMany(SystemPost::class, foreignPivotKey: 'post_id', relatedKey: 'admin_id')->using(SystemAdminPost::class);
    }

    public function depts()
    {
        return $this->belongsTo(SystemDept::class, 'dept_id', 'id');
    }
}
