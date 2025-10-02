<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

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

    public function getQueryScopeFragment(): string
    {

        if ($this->innerGetQueryParam('query_like', 'no') != 'yes') {
            return '';
        }

        $name = Str::studly($this->getFieldName());

        return <<<code
            protected function scope{$name}(Builder \$query, \$value)
            {
                \$query->where('{$this->getFieldName()}', 'like', "%\$value%");
            }
        code;

    }

    public function getFormCodeHtmlFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-input v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
            </a-form-item>
        code;
    }

    public function getIndexQueryHtmlFragment(): string
    {
        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <a-input v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
                </a-form-item>
            </search-col>
        code;
    }
}
