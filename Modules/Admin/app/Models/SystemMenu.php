<?php

namespace Modules\Admin\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemMenu extends AbstractModel
{
    use HasUuids;

    protected $table = 'system_menus';

    protected static function booted()
    {
        parent::booted();
        static::deleting(function ($model) {
            Permission::whereName($model->code)->delete();
        });
        static::created(function ($model) {
            Permission::firstOrCreate(['name' => $model->code, 'guard_name' => 'admin']);
        });
    }

    protected function casts()
    {
        return [
            'is_hidden'       => 'boolean',
            'is_auto_collect' => 'boolean',
            'allow_all'       => 'boolean',
            'allow_admin'     => 'boolean',
        ];
    }
}
