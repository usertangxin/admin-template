<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\App;
use Mews\Purifier\Facades\Purifier;
use Spatie\Translatable\HasTranslations;

class SystemConfig extends AbstractModel
{
    use HasTranslations, HasUuids;

    protected $table = 'system_configs';

    public array $translatable = [
        'name',
        'remark',
        'input_attr',
    ];

    protected $fillable = ['group', 'key', 'value', 'name', 'remark', 'input_type', 'bind_p_config', 'input_attr'];

    protected $casts = [
        'input_attr' => 'array',
    ];

    protected function value(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Purifier::clean($value),
        );
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
