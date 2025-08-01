<?php

namespace Modules\Admin\Models;

class SystemConfig extends AbstractModel
{
    protected $table = 'system_configs';

    protected $fillable = ['group', 'key', 'value', 'name', 'input_type', 'config_select_data', 'bind_p_config', 'input_attr'];

    protected $casts = [
        'config_select_data' => 'array',
        'input_attr'         => 'array',
    ];
}
