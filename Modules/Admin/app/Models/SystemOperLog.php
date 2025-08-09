<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

// use Modules\Admin\Database\Factories\SystemOperLogFactory;

class SystemOperLog extends AbstractSoftDelModel
{
    use HasUuids;
    
    protected $table = 'system_oper_logs';
}
