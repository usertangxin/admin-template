<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\App;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Translatable\HasTranslations;

class SystemMenu extends AbstractModel
{
    use HasTranslations, HasUuids;

    protected $table = 'system_menus';

    public bool $ignoreGlobalDataPermission = true;

    public array $translatable = ['name'];

    protected static function booted()
    {
        static::deleting(function ($model) {
            \app(PermissionRegistrar::class)->getPermissionClass()::whereName($model->code)->delete();
        });
        static::created(function ($model) {
            \app(PermissionRegistrar::class)->getPermissionClass()::firstOrCreate(['name' => $model->code, 'guard_name' => 'admin']);
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

    public function toArray()
    {
        $attributes = $this->attributesToArray();

        $translatable = array_filter($this->getTranslatableAttributes(), function ($key) use ($attributes) {
            return array_key_exists($key, $attributes);
        });
        foreach ($translatable as $field) {
            $attributes[$field] = $this->getTranslation($field, App::getLocale());
        }

        return array_merge($attributes, $this->relationsToArray());
    }
}
