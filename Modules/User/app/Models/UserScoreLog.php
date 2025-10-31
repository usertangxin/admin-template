<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

class UserScoreLog extends AbstractModel
{
    use HasUuids;

    protected $table = 'user_score_logs';

    protected $fillable = [
        'user_id',
        'score',
        'memo',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    protected static function booted()
    {
        self::creating(function (UserScoreLog $model) {
            $user = User::find($model->user_id);

            $userScore = $user->score;

            $model->before = $userScore;
            $userScore     = bcadd($userScore, $model->score, 0);
            $model->after  = $userScore;
            $user->score   = $userScore;
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
