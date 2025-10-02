<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlInputNumber extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamInputRange,
            new SpecialParamPrecision,
            new SpecialParamAllowedRadio('模式', 'mode', ['embed', 'button'], '请选择模式', defaultValue: 'embed'),
            new SpecialParamStep,
        ];
    }

    public function getQueryParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('范围查询', 'range_query'),
        ];
    }

    public function getRequestRules(): null|array|string
    {
        $a     = ['numeric'];
        $range = $this->innerGetSpecialParam('range', null);

        if ($range) {
            $a[] = 'between:' . $range[0] . ',' . $range[1];
        }

        return $a;
    }

    public function getModelCast(): ?string
    {
        $precision = $this->innerGetSpecialParam('precision', null);

        if ($precision !== null) {
            if ($precision <= 0) {
                return 'integer';
            }
            if ($precision <= 2) {
                return 'double';
            }
        }

        return 'float';
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
        $range     = $this->innerGetSpecialParam('range', []);
        $precision = $this->innerGetSpecialParam('precision', null);
        $mode      = $this->innerGetSpecialParam('mode', null);
        $step      = $this->innerGetSpecialParam('step', null);

        if ($range) {
            $attrs .= " :min=\"{$range[0]}\" :max=\"{$range[1]}\"";
        }
        if ($precision) {
            $attrs .= " :precision=\"{$precision}\"";
        }
        if ($mode) {
            $attrs .= " mode=\"{$mode}\"";
        }
        if ($step) {
            $attrs .= " :step=\"{$step}\"";
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <a-input-number v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"$attrs></a-input-number>
            </a-form-item>
        code;
    }
}
