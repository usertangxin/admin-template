<?php

namespace Modules\Admin\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsDecimal implements CastsAttributes
{

    public function __construct(
        public int $precision = 2,
    ) {
    }

    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return round($value, $this->precision);
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return round($value, $this->precision);
    }
}
