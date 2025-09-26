<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlSelect extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamKv(required: true),
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('多选', 'multiple'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getIndexQueryFragment(): string
    {
        // TODO
        return '';
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $kv          = $this->innerGetConfigParam('kv', []);
        $allowClear  = $this->innerGetConfigParam('allow-clear', 'no');
        $multiple    = $this->innerGetConfigParam('multiple', 'no');
        $allowSearch = $this->innerGetConfigParam('allow-search', 'no');
        $attrs       = '';

        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

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
                <a-select v-model="formData.{$this->getFieldName()}" :options='$options' placeholder="请选择{$this->getComment()}"$attrs></a-select>
            </a-form-item>
        code;
    }

    public function getMigrateCodeFragment(): string
    {
        // TODO
        return 'json(\'' . $this->field['field_name'] . '\')';
    }
}
