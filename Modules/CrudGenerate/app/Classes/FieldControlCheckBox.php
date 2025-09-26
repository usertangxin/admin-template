<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlCheckBox extends AbstractFieldControl
{
    public function getConfigParams(): array|string
    {
        return [
            new SpecialParamKv(required: true),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        return 'json(\'' . $this->field['field_name'] . '\')';
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $kv = $this->innerGetConfigParam('kv', []);
        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-checkbox-group v-model="formData.{$this->getFieldName()}" :options='$options'"></a-checkbox-group>
            </a-form-item>
        code;
    }

    public function getIndexQueryFragment(): string
    {
        $options = [];

        $kv = $this->innerGetConfigParam('kv', []);
        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return <<<code
            <search-col>
                <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                     <a-checkbox-group v-model="formData.{$this->getFieldName()}" :options='$options'"></a-checkbox-group>
                </a-form-item>
            </search-col>
        code;
    }
}
