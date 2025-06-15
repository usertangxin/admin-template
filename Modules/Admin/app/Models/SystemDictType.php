<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\SystemDictTypeFactory;

class SystemDictType extends SoftDelModel
{
    protected $table = 'system_dict_type';
}
