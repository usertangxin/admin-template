<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Translatable\HasTranslations;

class SystemConfig extends AbstractModel
{
    use HasTranslations, HasUuids;

    protected $table = 'system_configs';

    public array $translatable = [
        'name',
        'value',
        'remark',
        'input_attr',
    ];

    protected $fillable = ['group', 'key', 'value', 'name', 'remark', 'input_type', 'bind_p_config', 'input_attr'];

    protected $casts = [
        'input_attr' => 'array',
    ];

    public function toArray()
    {
        $attributes = $this->attributesToArray();

        $translatable = array_filter($this->getTranslatableAttributes(), function ($key) use ($attributes) {
            return array_key_exists($key, $attributes);
        });
        foreach ($translatable as $field) {
            $attributes[$field] = $this->getTranslation($field, \App::getLocale());
        }

        return array_merge($attributes, $this->relationsToArray());
    }
}
