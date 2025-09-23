<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamInput extends AbstractSpecialParam
{
    public function __construct(
        string $label = '文本',
        string $name = 'text',
        string $inputComponent = 'a-input',
        string $placeholder = '请输入文本',
        array $inputAttrs = [],
        mixed $defaultValue = null,
        bool $required = false,
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            array_merge([], $inputAttrs),
            $defaultValue,
            $required,
        );
    }
}
