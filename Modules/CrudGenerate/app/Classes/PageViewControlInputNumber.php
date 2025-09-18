<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlInputNumber extends AbstractPageViewControl
{

    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamInputRange(),
            new SpecialParamPrecision(),
            new SpecialParamAllowedRadio('模式', 'mode', ['embed', 'button'], '请选择模式', defaultValue: 'embed'),
            new SpecialParamStep(),
        ];
    }

    public function getFormCodeFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-input-number v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input-number>
            </a-form-item>
        code;
    }
}
