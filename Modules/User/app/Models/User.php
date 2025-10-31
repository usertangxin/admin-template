<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\AbstractSoftDelModel;

// use Modules\User\Database\Factories\UserFactory;

class User extends AbstractSoftDelModel
{
    use HasUuids;

    protected $fillable = [
        'parent_id', 'nickname', 'username', 'phone', 'email',
        'password', 'sex', 'avatar', 'birthday', 'vip',
        'alipay_name', 'alipay_account', 'status',
    ];

    protected $hidden = ['password'];

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }
        $this->attributes['password'] = Hash::make($value);
    }

    public function vipLevel()
    {
        return $this->belongsTo(UserVipLevel::class, 'vip', 'level');
    }
}
