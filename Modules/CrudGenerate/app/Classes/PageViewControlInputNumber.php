<?php

namespace Modules\CrudGenerate\Classes;

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

    public function getFormCodeFragment(): string
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
