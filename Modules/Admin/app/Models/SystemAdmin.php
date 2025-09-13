<?php

namespace Modules\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class SystemAdmin extends AbstractSoftDelModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasRoles;
    use HasUuids;

    public $ignoreGlobalDataPermission = true;

    protected $table = 'system_admins';

    protected $fillable = ['admin_name', 'password', 'nickname', 'phone', 'email', 'avatar', 'remark', 'status'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            if ($model->is_root) {
                throw new \Exception($model->nickname . '禁止删除');
            }
        });
        static::updating(function ($model) {
            if ($model->is_root) {

                if (\request()->user()->id != $model->id) {
                    throw new \Exception($model->nickname . '禁止编辑');
                }

                if ($model->isDirty('status')) {
                    throw new \Exception($model->nickname . '禁止更新状态');
                }
            }
        });
    }

    protected function casts()
    {
        return [
            'backend_setting' => 'json',
            'is_root'         => 'boolean',
        ];
    }

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }
        $this->attributes['password'] = Hash::make($value);
    }

    #[Scope]
    protected function fast_search(Builder $query, $fast_search)
    {
        $query->where('admin_name', 'like', '%' . $fast_search . '%')
            ->orWhere('nickname', 'like', '%' . $fast_search . '%')
            ->orWhere('email', 'like', '%' . $fast_search . '%')
            ->orWhere('phone', 'like', '%' . $fast_search . '%');
    }
}
