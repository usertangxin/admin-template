<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class SystemConfigGroup extends AbstractModel
{
    use HasTranslations, HasUuids;

    public array $translatable = ['name', 'remark'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'remark',
    ];

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
