<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlSlider extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamStep,
            new SpecialParamInputRange(defaultValue: [0, 100], name: 'range-value'),
            new SpecialParamYesOrNo('显示刻度', 'show-ticks'),
            new SpecialParamYesOrNo('显示输入框', 'show-input'),
            new SpecialParamKv('标签', 'marks', inputAttrs: ['keyTitle' => '显示内容', 'valueTitle' => '值']),
        ];
    }

    public function getRequestRules(): null|array|string
    {
        $range = $this->innerGetSpecialParam('range-value', [0, 100]);
        $a = ['numeric'];
        $a[] = 'between:' . $range[0] . ',' . $range[1];

        return $a;
    }

    public function getQueryParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('范围查询', 'range_query'),
        ];
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

    public function getFormCodeFragment(): string
    {
        $options = [];

        $rangeValue = $this->innerGetSpecialParam('range-value', [0, 100]);
        $step       = $this->innerGetSpecialParam('step', 1);
        $range      = $this->innerGetSpecialParam('range', 'no');
        $showTicks  = $this->innerGetSpecialParam('show-ticks', 'no');
        $showInput  = $this->innerGetSpecialParam('show-input', 'no');
        $marks      = $this->innerGetSpecialParam('marks', []);
        $attrs      = '';

        foreach ($marks as $item) {
            $options[$item[1]] = $item[0];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        $attrs .= ' :step="' . $step . '"';
        $attrs .= ' :min="' . $rangeValue[0] . '"';
        $attrs .= ' :max="' . $rangeValue[1] . '"';

        if ($range === 'yes') {
            $attrs .= ' range';
        }

        if ($showTicks === 'yes') {
            $attrs .= ' show-ticks';
        }

        if ($showInput === 'yes') {
            $attrs .= ' show-input';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-slider v-model="formData.{$this->getFieldName()}" :marks='$options'$attrs></a-slider>
            </a-form-item>
        code;
    }

    public function getIndexQueryFragment(): string
    {
        $range_query = $this->innerGetQueryParam('range_query', 'no');
        $input_type  = 'a-input-number';

        if ($range_query === 'yes') {
            $input_type = 'input-range';
        }

        return <<<code
            <search-col>
                <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                    <{$input_type} v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></{$input_type}>
                </a-form-item>
            </search-col>
        code;
    }
}
