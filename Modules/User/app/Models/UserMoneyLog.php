<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

class UserMoneyLog extends AbstractModel
{
    use HasUuids;

    protected $table = 'user_money_logs';

    protected $fillable = [
        'user_id',
        'money',
        'memo',
    ];

    protected $casts = [
        'money' => 'float',
    ];

    protected static function booted()
    {
        self::creating(function (UserMoneyLog $model) {
            $user = User::find($model->user_id);

            $userMoney = $user->money;

            $model->before = $userMoney;
            $userMoney   = bcadd($userMoney, $model->money, 2);
            $model->after  = $userMoney;
            $user->money = $userMoney;
            $user->save();
        });
    }

    /**
     * 获取关联的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}