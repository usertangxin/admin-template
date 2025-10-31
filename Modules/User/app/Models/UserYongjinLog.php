<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

class UserYongjinLog extends AbstractModel
{
    use HasUuids;

    protected $table = 'user_yongjin_logs';

    protected $fillable = [
        'user_id',
        'yongjin',
        'memo',
    ];

    protected $casts = [
        'yongjin' => 'float',
    ];

    protected static function booted()
    {
        self::creating(function (UserYongjinLog $model) {
            $user = User::find($model->user_id);

            $userYongjin = $user->yongjin;

            $model->before = $userYongjin;
            $userYongjin   = bcadd($userYongjin, $model->yongjin, 2);
            $model->after  = $userYongjin;
            $user->yongjin = $userYongjin;
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
