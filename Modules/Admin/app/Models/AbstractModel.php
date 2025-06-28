<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

// use Modules\Admin\Database\Factories\ModelFactory;

abstract class AbstractModel extends BaseModel
{
    use HasFactory;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $dateFormat = 'Y-m-d H:i:s';
}
