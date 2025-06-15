<?php

namespace Modules\Admin\Models;

class SystemConfig extends Model
{
    protected $table = 'system_config';
    public $timestamps = false;

    protected function casts()
    {
        return [
            'config_select_data' => 'json',
            'input_attr' => 'json',
        ];
    }
}
