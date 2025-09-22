<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamDictGroupSelect extends AbstractSpecialParam
{
    public function __construct(
        string $label = '字典',
        string $name = 'dict_code',
        string $inputComponent = 'dict-group-select',
        string $placeholder = '请选择字典编码',
        array $inputAttrs = ['style' => 'width: 220px'],
    ) {
        parent::__construct(
            label: $label,
            name: $name,
            inputComponent: $inputComponent,
            placeholder: $placeholder,
            inputAttrs: $inputAttrs,
        );
    }
}
