<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlRate extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('半选', 'allow-half', defaultValue: 'no'),
            new SpecialParamLength('长度', 'count', defaultValue: 5),
        ];
    }

    public function getRequestRules(): null|array|string
    {
        $a     = ['numeric'];
        $a[] = 'between:' . 0 . ',' . $this->innerGetSpecialParam('count', 5);
        return $a;
    }

    public function getQueryParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('范围查询', 'range_query'),
        ];
    }

    public function getModelCast(): ?string
    {
        return 'double';
    }

    public function getQueryScopeFragment(): string
    {

        if ($this->innerGetQueryParam('range_query', 'no') == 'yes') {
            $name = $this->getFieldName();
            $name = Str::studly($name);

            return <<<code
                protected function scope{$name}(Builder \$query, \$value)
                {
                    if (\$value && is_array(\$value) && count(\$value) == 2) {
                        \$query->whereBetween('{$this->getFieldName()}', \$value);
                    } else {
                        \$query->where('{$this->getFieldName()}', \$value);
                    }
                }
            code;
        }

        return '';
    }

    public function getIndexQueryHtmlFragment(): string
    {
        $range_query = $this->innerGetQueryParam('range_query', 'no');
        $input_type  = 'a-input-number';

        if ($range_query === 'yes') {
            $input_type = 'input-range';
        }

        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <{$input_type} v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></{$input_type}>
                </a-form-item>
            </search-col>
        code;
    }

    public function getFormCodeHtmlFragment(): string
    {
        $attrs     = '';
        $count     = $this->innerGetSpecialParam('count', null);
        $allowHalf = $this->innerGetSpecialParam('allow-half', 'no');
        if ($count) {
            $attrs .= " :count=\"$count\"";
        }
        if ($allowHalf === 'yes') {
            $attrs .= ' :allow-half="true"';
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <a-rate v-model="formData.{$this->getFieldName()}"$attrs></a-rate>
            </a-form-item>
        code;
    }
}
