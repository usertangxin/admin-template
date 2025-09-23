<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUuids;
    use SoftDeletes;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat);
    }

    protected $fillable = [
        'name',
        'guard_name',
        'remark',
        'status',
    ];

    #[Scope]
    protected function fast_search($query, $value)
    {
        return $query->where('name', 'like', "%{$value}%")->orWhere('remark', 'like', "%{$value}%");
    }
}
