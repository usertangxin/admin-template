<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlSwitch extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamAllowedRadio('类型', 'type', ['circle', 'round', 'line'], defaultValue: 'circle'),
            new SpecialParamInput('选中的值', 'checked-value', placeholder: '字符串需要加引号'),
            new SpecialParamInput('未选中时的值', 'unchecked-value', placeholder: '字符串需要加引号'),
            new SpecialParamInput('选中时的文本', 'checked-text', placeholder: "（type='line'和size='small'时不生效）"),
            new SpecialParamInput('未选中时的文本', 'unchecked-text', placeholder: "（type='line'和size='small'时不生效）"),
        ];
    }

    public function getFormCodeFragment(): string
    {

        $checkedValue   = $this->innerGetSpecialParam('checked-value');
        $uncheckedValue = $this->innerGetSpecialParam('unchecked-value');
        $checkedText    = $this->innerGetSpecialParam('checked-text');
        $uncheckedText  = $this->innerGetSpecialParam('unchecked-text');
        $type           = $this->innerGetSpecialParam('type', 'circle');

        $attrs = ' type="' . $type . '"';

        if ($checkedValue !== null) {
            $checkedValue = str_replace('\'', '"', $checkedValue);
            $attrs .= ' :checked-value=\'' . $checkedValue . '\'';
        }
        if ($uncheckedValue !== null) {
            $uncheckedValue = str_replace('\'', '"', $uncheckedValue);
            $attrs .= ' :unchecked-value=\'' . $uncheckedValue . '\'';
        }
        if ($checkedText !== null) {
            $attrs .= ' checked-text="' . $checkedText . '"';
        }
        if ($uncheckedText !== null) {
            $attrs .= ' unchecked-text="' . $uncheckedText . '"';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-switch v-model="formData.{$this->getFieldName()}"$attrs></a-switch>
            </a-form-item>
        code;
    }
}
