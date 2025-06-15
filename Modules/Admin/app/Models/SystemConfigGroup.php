<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Admin\Database\Factories\SystemConfigGroupFactory;

class SystemConfigGroup extends SoftDelModel
{
    protected $table = 'system_config_group';
}
