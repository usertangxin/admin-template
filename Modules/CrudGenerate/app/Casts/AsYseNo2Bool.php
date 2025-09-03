<?php

namespace Modules\CrudGenerate\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsYseNo2Bool implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return \is_bool($value) ? $value : $value == 'yes';
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value ? 'yes' : 'no';
    }
}
