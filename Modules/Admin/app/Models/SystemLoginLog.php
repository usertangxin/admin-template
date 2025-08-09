<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

// use Modules\Admin\Database\Factories\SystemLoginLogFactory;

class SystemLoginLog extends AbstractSoftDelModel
{
    use HasUuids;
    
    protected $table = 'system_login_logs';
}
