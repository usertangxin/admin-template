<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamAllowedRadio extends AbstractSpecialParam
{
    public function __construct(
        string $label = '允许的值',
        string $name = 'allowed',
        array $options = [],
        string $placeholder = '请选择允许的值',
        string $inputComponent = 'a-radio-group',
        array $inputAttrs = [],
        mixed $defaultValue = null,
        bool $required = false,
    ) {
        $trans_options = [];
        foreach ($options as $value) {
            $trans_options[] = [
                'label' => $value,
                'value' => $value,
            ];
        }
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            \array_merge(['options' => $trans_options], $inputAttrs),
            $defaultValue,
            $required,
        );
    }
}
