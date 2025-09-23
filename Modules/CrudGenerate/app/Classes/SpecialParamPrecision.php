<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamPrecision extends AbstractSpecialParam
{
    public function __construct(
        string $label = '精度',
        string $name = 'precision',
        string $inputComponent = 'a-input-number',
        string $placeholder = '请输入精度',
        array $inputAttrs = [],
        mixed $defaultValue = null,
        bool $required = false,
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            array_merge(['mode' => 'button', 'precision' => 0, 'step' => 1, 'min' => 0], $inputAttrs),
            $defaultValue,
            $required,
        );
    }
}
