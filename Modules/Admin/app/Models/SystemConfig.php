<?php

namespace Modules\Admin\Models;

class SystemConfig extends AbstractModel
{
    protected $table = 'system_configs';

    public $timestamps = false;

    protected $fillable = ['key', 'value'];
}
