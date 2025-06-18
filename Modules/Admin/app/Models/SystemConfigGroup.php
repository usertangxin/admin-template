<?php

namespace Modules\Admin\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Admin\Database\Factories\SystemConfigGroupFactory;

class SystemConfigGroup extends AbstractSoftDelModel
{
    protected $table = 'system_config_group';
}
