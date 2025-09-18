<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlInput extends AbstractPageViewControl
{
    public function getFormCodeFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-input v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
            </a-form-item>
        code;
    }
}
