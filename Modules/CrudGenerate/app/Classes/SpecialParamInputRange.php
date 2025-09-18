<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamInputRange  extends AbstractSpecialParam
{
    public function __construct(
        string $label = '范围',
        string $name = 'range',
        string $inputComponent = 'input-range',
        string $placeholder = '请输入范围',
        array $inputAttrs = [],
        mixed $defaultValue = null
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            array_merge(['mode' => 'button', 'precision' => 0, 'step' => 1, 'min' => 1, 'max' => 255], $inputAttrs),
            $defaultValue,
        );
    }
}
