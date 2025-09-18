<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlInputNumber extends AbstractPageViewControl
{

    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamInputRange(),
            new SpecialParamPrecision(),
            new SpecialParamAllowedRadio('模式', 'mode', ['embed', 'button'], '请选择模式', defaultValue: 'embed'),
            new SpecialParamStep(),
        ];
    }

    public function getFormCodeFragment(): string
    {
        $attrs = '';
        $range = $this->field['page_view_control_special_params']['range'] ?? [];
        $precision = $this->field['page_view_control_special_params']['precision'] ?? null;
        $mode = $this->field['page_view_control_special_params']['mode'] ?? null;
        $step = $this->field['page_view_control_special_params']['step'] ?? null;
        if($range) {
            $attrs .= " :min=\"{$range[0]}\" :max=\"{$range[1]}\"";
        }
        if($precision) {
            $attrs .= " :precision=\"{$precision}\"";
        }
        if($mode) {
            $attrs .= " :mode=\"{$mode}\"";
        }
        if($step) {
            $attrs .= " :step=\"{$step}\"";
        }
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-input-number v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"$attrs></a-input-number>
            </a-form-item>
        code;
    }
}
