<?php

namespace Modules\Admin\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

// use Modules\Admin\Database\Factories\ModelFactory;

abstract class AbstractModel extends BaseModel
{
    use HasFactory;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat);
    }
}
