<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamAllowed extends AbstractSpecialParam
{
    public function __construct(
        string $label = '允许的值',
        string $name = 'allowed',
        string $inputComponent = 'a-input-tag',
        string $placeholder = '请输入允许的值并回车',
        array $inputAttrs = [],
        mixed $defaultValue = null
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            \array_merge(['style'=>['width' => '320px']], $inputAttrs),
            $defaultValue,
        );
    }
}
