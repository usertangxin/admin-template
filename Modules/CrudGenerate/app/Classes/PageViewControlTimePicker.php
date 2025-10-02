<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlTimePicker extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return <<<'code'
            <a-form-item label="跳过确认">
                <dict-radio v-model="params.disable_confirm" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
            <a-form-item label="定制步长">
                <a-input-group>
                    <a-input-number v-model="params.step_hour" placeholder="时" :min="1" :max="23"></a-input-number>
                    <a-input-number v-model="params.step_minute" placeholder="分" :min="1" :max="59"></a-input-number>
                    <a-input-number v-model="params.step_second" placeholder="秒" :min="1" :max="59"></a-input-number>
                </a-input-group>
            </a-form-item>
        code;
    }

    public function getRequestRules(): null|array|string
    {
        $a = ['date_format:H:i:s'];
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
        return 'datetime:H:i:s';
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
        $input_type = 'a-time-picker';
        /** 更多属性 */
        $attrs = '';
        /** 日期选择器组件 v-model 绑定的变量名 */
        $v_model = 'v-model';

        $is_range        = $this->innerGetQueryParam('range_query', 'no');
        $disable_confirm = $this->innerGetSpecialParam('disable_confirm', 'no');
        $step_hour       = $this->innerGetSpecialParam('step_hour', null);
        $step_minute     = $this->innerGetSpecialParam('step_minute', null);
        $step_second     = $this->innerGetSpecialParam('step_second', null);

        if ($is_range == 'yes') {
            $attrs .= ' type="time-range"';
        }
        if ($disable_confirm == 'yes') {
            $attrs .= ' :disable-confirm="true"';
        }
        if ($step_hour !== null || $step_minute !== null || $step_second !== null) {
            $attrs .= ' :step="{hour: ' . ($step_hour ?? 1) . ', minute: ' . ($step_minute ?? 1) . ', second: ' . ($step_second ?? 1) . '}"';
        }

        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <$input_type $v_model="store.searchQuery.{$this->getFieldName()}" placeholder="请选择{$this->getComment()}"$attrs></$input_type>
                </a-form-item>
             </search-col>
        code;
    }

    public function getFormCodeFragment(): string
    {
        /** 日期选择器组件类型 */
        $input_type = 'a-time-picker';
        /** 更多属性 */
        $attrs = '';
        /** 日期选择器组件 v-model 绑定的变量名 */
        $v_model = 'v-model';

        // $is_range        = $this->innerGetSpecialParam('is_range', 'no');
        $disable_confirm = $this->innerGetSpecialParam('disable_confirm', 'no');
        $step_hour       = $this->innerGetSpecialParam('step_hour', null);
        $step_minute     = $this->innerGetSpecialParam('step_minute', null);
        $step_second     = $this->innerGetSpecialParam('step_second', null);

        // if ($is_range == 'yes') {
        //     $attrs .= ' type="time-range"';
        // }
        if ($disable_confirm == 'yes') {
            $attrs .= ' :disable-confirm="true"';
        }
        if ($step_hour !== null || $step_minute !== null || $step_second !== null) {
            $attrs .= ' :step="{hour: ' . ($step_hour ?? 1) . ', minute: ' . ($step_minute ?? 1) . ', second: ' . ($step_second ?? 1) . '}"';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <$input_type $v_model="formData.{$this->getFieldName()}" placeholder="请选择{$this->getComment()}"$attrs></$input_type>
            </a-form-item>
        code;
    }
}
