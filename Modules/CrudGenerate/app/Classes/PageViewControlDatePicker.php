<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlDatePicker extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return <<<'code'
            <a-form-item label="类型">
                <a-radio-group v-model="params.type" :options="[{label: '日期选择器', value: 'date'}, {label: '日期时间选择', value: 'datetime'}, {label: '月份选择器', value: 'month'}, {label: '年份选择器', value: 'year'}, {label: '周选择器', value: 'week'}, {label: '季度选择器', value: 'quarter'},]" default-value="date"></a-radio-group>
            </a-form-item>
            <a-form-item label="使用面板">
                <dict-radio v-model="params.use_panel" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
        code;
    }

    private function getFormat()
    {
        $type = $this->innerGetSpecialParam('type', 'date');
        if ($type == 'date') {
            return 'Y-m-d';
        }

        if ($type == 'month') {
            return 'Y-m';
        }

        if ($type == 'year') {
            return 'Y';
        }

        if ($type == 'week') {
            return 'oW';
        }

        if ($type == 'quarter') {
            return 'Y-Q';
        }

        return 'Y-m-d H:i:s';
    }

    public function getModelCast(): ?string
    {
        return 'datetime:' . $this->getFormat();
    }

    public function getRequestRules(): null|array|string
    {
        return 'date_format:' . $this->getFormat();
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

    public function getIndexQueryHtmlFragment(): string
    {
        /** 日期选择器组件类型 */
        $input_type = 'a-date-picker';
        /** 更多属性 */
        $attrs = '';
        /** 日期选择器组件 v-model 绑定的变量名 */
        $v_model = 'v-model';
        /** 是否为特殊组件 */
        $in_special_view = false;

        $type = $this->innerGetSpecialParam('type', 'date');
        // $use_panel = $this->innerGetSpecialParam('use_panel', 'no');
        $is_range = $this->innerGetQueryParam('range_query', 'no');

        if (in_array($type, ['month', 'year', 'week', 'quarter'])) {
            $in_special_view = true;
        }

        // if ($use_panel == 'yes') {
        //     $v_model = 'v-model:pickerValue';
        //     $attrs .= ' hide-trigger';
        // }

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
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <$input_type $v_model="store.searchQuery.{$this->getFieldName()}" placeholder="请选择{$this->getComment()}"$attrs></$input_type>
                </a-form-item>
             </search-col>
         code;
    }

    public function getFormCodeHtmlFragment(): string
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

        if (in_array($type, ['month', 'year', 'week', 'quarter'])) {
            $in_special_view = true;
        }

        if ($use_panel == 'yes') {
            $v_model = 'v-model:pickerValue';
            $attrs .= ' hide-trigger';
        }

        if ($in_special_view) {
            $input_type = 'a-' . $type . '-picker';
        }

        if ($type == 'datetime') {
            $attrs .= ' show-time';
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <$input_type $v_model="formData.{$this->getFieldName()}" placeholder="请选择{$this->getComment()}"$attrs></$input_type>
            </a-form-item>
        code;
    }
}
