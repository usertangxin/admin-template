<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlDatePicker extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return <<<'code'
            <a-form-item label="类型">
                <a-radio-group v-model="params.type" :options="[{label: '日期选择器', value: 'date'}, {label: '日期时间选择', value: 'datetime'}, {label: '月份选择器', value: 'month'}, {label: '年份选择器', value: 'year'}, {label: '周选择器', value: 'week'}, {label: '季度选择器', value: 'quarter'},]" default-value="date"></a-radio-group>
            </a-form-item>
            <a-form-item label="范围选择">
                <dict-radio v-model="params.is_range" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
            <a-form-item label="使用面板">
                <dict-radio v-model="params.use_panel" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
        code;
    }

    public function getQueryParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('范围查询', 'range_query'),
        ];
    }

    public function getFormCodeFragment(): string
    {
        /** 日期选择器组件类型 */
        $input_type = 'a-date-picker';
        /** 更多属性 */
        $attrs = '';
        /** 日期选择器组件 v-model 绑定的变量名 */
        $v_model = 'v-model';
        /** 是否为特殊组件 */
        $in_special_view = false;

        $type      = $this->innerGetSpecialParam('type', 'date');
        $use_panel = $this->innerGetSpecialParam('use_panel', 'no');
        $is_range  = $this->innerGetSpecialParam('is_range', 'no');

        if (in_array($type, ['month', 'year', 'week', 'quarter'])) {
            $in_special_view = true;
        }

        if ($use_panel == 'yes') {
            $v_model = 'v-model:pickerValue';
            $attrs .= ' hide-trigger';
        }

        if ($is_range == 'yes') {
            $input_type = 'a-range-picker';

            if ($in_special_view) {
                $attrs .= ' mode="' . $type . '"';
            }
        } else {
            if ($in_special_view) {
                $input_type = 'a-' . $type . '-picker';
            }
        }

        if ($type == 'datetime') {
            $attrs .= ' show-time';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <$input_type $v_model="formData.{$this->getFieldName()}" placeholder="请选择{$this->getComment()}"$attrs></$input_type>
            </a-form-item>
        code;
    }
}
