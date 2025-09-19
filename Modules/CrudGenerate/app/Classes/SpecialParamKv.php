<?php

namespace Modules\CrudGenerate\Classes;

class SpecialParamKv extends AbstractSpecialParam
{
    public function __construct(
        string $label = '选项',
        string $name = 'kv',
        string $inputComponent = 'input-kv',
        string $placeholder = '请输入选项',
        array $inputAttrs = [],
        mixed $defaultValue = [],
    ) {
        parent::__construct(
            $label,
            $name,
            $inputComponent,
            $placeholder,
            array_merge(['keyTitle' => 'Label', 'valueTitle' => 'Value'], $inputAttrs),
            $defaultValue,
        );
    }
}
