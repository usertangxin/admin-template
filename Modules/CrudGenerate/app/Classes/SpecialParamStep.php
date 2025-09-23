<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamStep extends AbstractSpecialParam
{
    public function __construct(
        string $label = '步长',
        string $name = 'step',
        string $inputComponent = 'a-input-number',
        string $placeholder = '请输入步长',
        array $inputAttrs = [],
        mixed $defaultValue = 1,
        bool $required = false,
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            array_merge(['mode' => 'button', 'step' => 1, 'min' => 0], $inputAttrs),
            $defaultValue,
            $required,
        );
    }
}
