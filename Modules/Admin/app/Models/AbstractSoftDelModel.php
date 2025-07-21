<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractSoftDelModel extends AbstractModel
{
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';
}
