<?php

namespace Modules\Admin\Models;

// use Modules\Admin\Database\Factories\SystemDictTypeFactory;

class SystemDictType extends AbstractModel
{
    protected $table = 'system_dict_types';

    protected $fillable = [
        'name',
        'code',
        'remark',
    ];
}
