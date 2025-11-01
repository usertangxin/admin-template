<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

class UserIntegralLog extends AbstractModel
{
    use HasUuids;

    protected $table = 'user_integral_logs';

    protected $fillable = [
        'user_id',
        'integral',
        'memo',
        'operation',
    ];

    protected $casts = [
        'integral' => 'integer',
    ];

    /**
     * 获取关联的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
