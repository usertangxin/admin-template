<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SoftDelModel extends Model
{
    use SoftDeletes;
    const DELETED_AT = 'delete_time';
}
