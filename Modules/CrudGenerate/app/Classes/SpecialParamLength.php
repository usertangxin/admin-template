<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamLength extends AbstractSpecialParam
{
    public function __construct(
        string $label = '长度',
        string $name = 'length',
        string $inputComponent = 'a-input-number',
        string $placeholder = '请输入长度',
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
