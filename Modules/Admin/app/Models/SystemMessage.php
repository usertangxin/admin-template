<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemMessage extends AbstractSoftDelModel
{
    use HasUuids;
    
    protected $table = 'system_messages';
}
