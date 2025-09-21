<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlSlider extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamStep,
            new SpecialParamInputRange(defaultValue: [0, 100], name: 'range-value'),
            new SpecialParamYesOrNo('范围选择', 'range'),
            new SpecialParamYesOrNo('显示刻度', 'show-ticks'),
            new SpecialParamYesOrNo('显示输入框', 'show-input'),
            new SpecialParamKv('标签', 'marks', inputAttrs: ['keyTitle' => '显示内容', 'valueTitle' => '值']),
        ];
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $rangeValue = $this->field['page_view_control_special_params']['range-value'] ?? [0, 100];
        $step       = $this->field['page_view_control_special_params']['step'] ?? 1;
        $range      = $this->field['page_view_control_special_params']['range'] ?? 'no';
        $showTicks  = $this->field['page_view_control_special_params']['show-ticks'] ?? 'no';
        $showInput  = $this->field['page_view_control_special_params']['show-input'] ?? 'no';
        $marks      = $this->field['page_view_control_special_params']['marks'] ?? [];
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
}
