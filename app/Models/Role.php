<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use SoftDeletes;
    use HasUuids;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat);
    }
}
