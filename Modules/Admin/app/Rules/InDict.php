<?php

namespace Modules\Admin\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Validator;
use Modules\Admin\Services\SystemDictService;

/**
 * 验证字段值是否在字典中，如果是数组则值都应该在字典中
 */
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
    public function validate(string $attribute, mixed $value, Closure|Validator $fail): void
    {
        if (! is_array($value)) {
            $value = [$value];
        }
        foreach ($value as $v) {
            if (! SystemDictService::getInstance()->getValuesByCode($this->dictCode)->contains($v)) {
                $fail(__('admin::validation.in_dict', [
                    'value'     => $v,
                    'dict'      => $this->dictCode,
                    'attribute' => $attribute,
                ]));
            }
        }
    }
}
