<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

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
        return [
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getQueryScopeFragment(): string
    {
        $mul_select = $this->innerGetQueryParam('mul_select', 'no');

        if ($mul_select == 'yes') {
            $name = $this->getFieldName();
            $name = Str::studly($name);
            return <<<code
                protected function scope{$name}(Builder \$query, \$value)
                {
                    if (\$value && is_array(\$value) && count(\$value) > 0) {
                        \$query->whereIn('{$this->getFieldName()}', \$value);
                    } else {
                        \$query->where('{$this->getFieldName()}', \$value);
                    }
                }
            code;
        }

        return '';
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
