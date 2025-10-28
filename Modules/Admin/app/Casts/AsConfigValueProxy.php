<?php

namespace Modules\Admin\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Database\Eloquent\Model;

class AsConfigValueProxy implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (
            ! empty($attributes['value_cast'])
            && class_exists($attributes['value_cast'])
            && (is_subclass_of($attributes['value_cast'], CastsAttributes::class))
        ) {
            $class = new $attributes['value_cast'];

            return $class->get($model, $key, $value, $attributes);
        }

        return $value;
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (
            ! empty($attributes['value_cast'])
            && class_exists($attributes['value_cast'])
            && (is_subclass_of($attributes['value_cast'], CastsAttributes::class) || is_subclass_of($attributes['value_cast'], CastsInboundAttributes::class))
        ) {
            $class = new $attributes['value_cast'];

            return $class->set($model, $key, $value, $attributes);
        }

        return $value;
    }
}
