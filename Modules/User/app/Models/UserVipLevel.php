<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractModel;

// use Modules\User\Database\Factories\UserVipLevelFactory;

class UserVipLevel extends AbstractModel
{
    use HasUuids;

    protected $fillable = [
        'name',
        'icon_image',
        'level',
        'status',
    ];
}
