<?php

namespace Modules\Admin\Models;

class SystemDict extends AbstractModel
{
    protected $table = 'system_dicts';

    protected $fillable = [
        'label',
        'value',
        'code',
        'color',
    ];
}
