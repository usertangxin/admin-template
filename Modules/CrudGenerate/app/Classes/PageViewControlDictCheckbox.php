<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlDictCheckbox extends AbstractPageViewControl
{

    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect,
        ];
    }

    public function getFormCodeFragment(): string
    {

        $dictCode = $this->innerGetSpecialParam('dict_code');

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <dict-checkbox v-model="formData.{$this->getFieldName()}" code="{$dictCode}"></dict-checkbox>
            </a-form-item>
        code;
    }
}
