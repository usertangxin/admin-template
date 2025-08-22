<?php

namespace Modules\Admin\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Admin\Services\SystemDictService;

class InDict implements ValidationRule
{
    protected $dictCode;

    public function __construct($dictCode)
    {
        $this->dictCode = $dictCode;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!SystemDictService::getInstance()->getValuesByCode($this->dictCode)->contains($value)) {
            $fail('The :attribute is not in the dictionary .', );
        }
    }
}
