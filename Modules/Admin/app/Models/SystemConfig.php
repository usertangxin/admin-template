<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemConfig extends AbstractModel
{
    use HasUuids;

    protected $table = 'system_configs';

    protected $fillable = ['group', 'key', 'value', 'name', 'input_type', 'config_select_data', 'bind_p_config', 'input_attr'];

    protected $casts = [
        'config_select_data' => 'array',
        'input_attr'         => 'array',
    ];
}
