<?php

namespace Modules\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class SystemAdmin extends AbstractSoftDelModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    protected $table = 'system_admin';

    protected function casts()
    {
        return [
            'backend_setting' => 'json',
        ];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
