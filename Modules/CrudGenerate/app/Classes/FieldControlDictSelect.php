<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlDictSelect extends AbstractFieldControl
{
    public function getIndexQueryFragment(): string
    {
        // TODO: 索引查询
        return '';
    }
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('多选', 'multiple'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $dictCode    = $this->innerGetConfigParam('dict_code');
        $allowClear  = $this->innerGetConfigParam('allow-clear', 'no');
        $multiple    = $this->innerGetConfigParam('multiple', 'no');
        $allowSearch = $this->innerGetConfigParam('allow-search', 'no');
        $attrs       = '';

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        if ($allowClear === 'yes') {
            $attrs .= ' allow-clear';
        }

        if ($multiple === 'yes') {
            $attrs .= ' multiple';
        }

        if ($allowSearch === 'yes') {
            $attrs .= ' allow-search';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <dict-select v-model="formData.{$this->getFieldName()}" code="{$dictCode}" placeholder="请输入{$this->getComment()}"$attrs></dict-select>
            </a-form-item>
        code;
    }

    public function getMigrateCodeFragment(): string
    {
        return 'json(\'' . $this->field['field_name'] . '\')';
    }
}
