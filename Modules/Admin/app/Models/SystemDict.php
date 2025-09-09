<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemDict extends AbstractModel
{
    use HasUuids;

    protected $table = 'system_dictionaries';

    protected $fillable = [
        'label',
        'value',
        'code',
        'color',
        'status',
    ];
}
