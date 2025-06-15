<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\SystemUserFactory;

class SystemUser extends SoftDelModel
{
    protected $table = 'system_user';

    protected function casts()
    {
        return [
            'backend_setting' => 'json',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(SystemRole::class, foreignPivotKey: 'role_id', relatedKey: 'user_id')->using(SystemUserRole::class);
    }

    public function posts()
    {
        return $this->belongsToMany(SystemPost::class, foreignPivotKey: 'post_id', relatedKey: 'user_id')->using(SystemUserPost::class);
    }

    public function depts()
    {
        return $this->belongsTo(SystemDept::class, 'dept_id', 'id');
    }
}
