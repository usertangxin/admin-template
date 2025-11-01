<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

class UserBalanceLog extends AbstractModel
{
    use HasUuids;

    protected $table = 'user_balance_logs';

    protected $fillable = [
        'user_id',
        'balance',
        'memo',
        'operation',
    ];

    protected $casts = [
        'balance' => 'float',
    ];

    /**
     * 获取关联的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
