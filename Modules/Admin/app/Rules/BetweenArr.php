<?php

namespace Modules\Admin\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 验证数组是否在指定范围内,这个值必须是数组,且数组元素数量为2,且数组元素值在指定范围内
 */
class BetweenArr implements ValidationRule
{
    protected $between = [];

    public function __construct($min, $max)
    {
        $this->between = [min($min, $max), max($min, $max)];
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            $fail(__('admin::validation.between_arr.type', ['attribute' => $attribute]));
        }

        if (count($value) !== 2) {
            $fail(__('admin::validation.between_arr.count', ['attribute' => $attribute]));
        }

        if (! is_numeric($value[0]) || ! is_numeric($value[1])) {
            $fail(__('admin::validation.between_arr.number', ['attribute' => $attribute]));
        }

        $value = sort($value);

        if ($value[0] < $this->between[0] || $value[1] > $this->between[1]) {
            $fail(__('admin::validation.between_arr.between', [
                'attribute' => $attribute,
                'min'       => $this->between[0],
                'max'       => $this->between[1],
            ]));
        }
    }
}
