<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

// use Modules\Admin\Database\Factories\SystemPostFactory;

class SystemPost extends AbstractSoftDelModel
{
    use HasUuids;

    protected $table = 'system_posts';
}
