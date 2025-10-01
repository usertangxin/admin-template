<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Support\Str;

class PageViewControlDictCheckbox extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
        ];
    }

    public function getModelCast(): ?string
    {
        return AsArrayObject::class;
    }

    public function getRequestRules(): null|array|string
    {
        $dictCode = $this->innerGetSpecialParam('dict_code');

        return [
            'array',
            'in_dict:' . $dictCode,
        ];
    }

    public function getQueryParams(): array|string
    {
        return [];
    }

    public function getQueryScopeFragment(): string
    {
        $name = Str::studly($this->getFieldName());

        return <<<code
            protected function scope{$name}(Builder \$query, \$value)
            {
                \$query->whereJsonContains('{$this->getFieldName()}', \$value);
            }
        code;
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
