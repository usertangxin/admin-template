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

    public function getQueryParams(): array|string
    {
        return [];
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

    public function getIndexQueryFragment(): string
    {
        $dictCode = $this->innerGetSpecialParam('dict_code');

        $attrs = '  allow-clear allow-search';

        return <<<code
            <search-col>
                <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                    <dict-select v-model="store.searchQuery.{$this->getFieldName()}" code="{$dictCode}" placeholder="请选择{$this->getComment()}"$attrs></dict-select>
                </a-form-item>
             </search-col>
         code;
    }
}
