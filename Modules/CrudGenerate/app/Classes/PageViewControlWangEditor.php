<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlWangEditor extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [];
    }

    public function getQueryScopeFragment(): string
    {
        return '';
    }

    public function getFormCodeHtmlFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <wang-editor v-model="formData.{$this->getFieldName()}"></wang-editor>
            </a-form-item>
        code;
    }

    public function getIndexQueryHtmlFragment(): string
    {
        return '';
    }
}
