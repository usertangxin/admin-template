<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

class UserCommissionLog extends AbstractModel
{
    use HasUuids;

    protected $table = 'user_commission_logs';

    protected $fillable = [
        'user_id',
        'commission',
        'memo',
        'operation',
    ];

    protected $casts = [
        'commission' => 'float',
    ];

    /**
     * 获取关联的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
