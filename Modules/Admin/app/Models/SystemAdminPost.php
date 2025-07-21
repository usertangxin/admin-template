<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemadminPostFactory;

class SystemAdminPost extends Pivot
{
    protected $table = 'system_admin_posts';

    public $incrementing = true;

    public $timestamps = false;
}
