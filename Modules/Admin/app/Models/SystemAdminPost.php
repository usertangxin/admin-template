<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

// use Modules\Admin\Database\Factories\SystemadminPostFactory;

class SystemAdminPost extends Pivot
{
    use HasUuids;

    protected $table = 'system_admin_posts';

    public $incrementing = true;

    public $timestamps = false;
}
