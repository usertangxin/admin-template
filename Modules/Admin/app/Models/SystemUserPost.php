<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemUserPostFactory;

class SystemUserPost extends Pivot
{
    protected $table = 'system_user_post';

    public $incrementing = true;

    public $timestamps = false;
}
