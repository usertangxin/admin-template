<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlInput extends AbstractPageViewControl
{
    public function getQueryParams(): array|string
    {
        return <<<'code'
            <a-form-item label="是否模糊查询" field="query_like">
                <dict-radio v-model="params.query_like" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
        code;
    }

    public function getFormCodeFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-input v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
            </a-form-item>
        code;
    }

    public function getIndexQueryFragment(): string
    {
        return <<<code
            <search-col>
                <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                    <a-input v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
                </a-form-item>
            </search-col>
        code;
    }
}
