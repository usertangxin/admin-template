<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamYesOrNo extends AbstractSpecialParam
{
    public function __construct(
        string $label,
        string $name,
        string $inputComponent = 'dict-radio',
        string $placeholder = '请选择',
        array $inputAttrs = ['code' => 'yes_or_no'],
        mixed $defaultValue = 'no'
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            array_merge(['code' => 'yes_or_no'], $inputAttrs),
            $defaultValue,
        );
    }
}