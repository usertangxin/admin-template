<?php

namespace Modules\Admin\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
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
        $cast = $attributes['value_cast'] ?? '';
        $parseClass = $this->parseCasterClass($cast);
        if (class_exists($parseClass)
            && (is_subclass_of($parseClass, CastsAttributes::class))
        ) {
            $class = $this->resolveCasterClass($cast);

            return $class->get($model, $key, $value, $attributes);
        }

        return $value;
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $cast = $attributes['value_cast'] ?? '';
        $parseClass = $this->parseCasterClass($cast);
        if (class_exists($parseClass)
            && (is_subclass_of($parseClass, CastsAttributes::class) || is_subclass_of($parseClass, CastsInboundAttributes::class))
        ) {
            $class = $this->resolveCasterClass($cast);

            return $class->set($model, $key, $value, $attributes);
        }

        return $value;
    }

    /**
     * Resolve the custom caster class for a given key.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function resolveCasterClass($castType)
    {
        $arguments = [];

        if (is_string($castType) && str_contains($castType, ':')) {
            $segments = explode(':', $castType, 2);

            $castType = $segments[0];
            $arguments = explode(',', $segments[1]);
        }

        if (is_subclass_of($castType, Castable::class)) {
            $castType = $castType::castUsing($arguments);
        }

        if (is_object($castType)) {
            return $castType;
        }

        return new $castType(...$arguments);
    }

    /**
     * Parse the given caster class, removing any arguments.
     *
     * @param  string  $class
     * @return string
     */
    protected function parseCasterClass($class)
    {
        return ! str_contains($class, ':')
            ? $class
            : explode(':', $class, 2)[0];
    }
}
