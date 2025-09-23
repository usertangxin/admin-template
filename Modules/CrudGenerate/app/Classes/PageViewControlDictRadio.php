<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlDictRadio extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
        ];
    }

    public function getFormCodeFragment(): string
    {

        $dictCode = $this->innerGetSpecialParam('dict_code');

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <dict-radio v-model="formData.{$this->getFieldName()}" code="{$dictCode}"></dict-radio>
            </a-form-item>
        code;
    }
}
