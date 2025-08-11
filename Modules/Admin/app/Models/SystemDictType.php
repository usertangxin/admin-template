<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

// use Modules\Admin\Database\Factories\SystemDictTypeFactory;

class SystemDictType extends AbstractModel
{
    use HasUuids;

    protected $table = 'system_dict_types';

    protected $fillable = [
        'name',
        'code',
        'remark',
    ];
}
