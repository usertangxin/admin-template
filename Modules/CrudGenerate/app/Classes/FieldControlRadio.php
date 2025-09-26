<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlRadio extends AbstractFieldControl
{
    public function getIndexQueryFragment(): string
    {
        // TODO 索引查询
        return '';
    }
    public function getConfigParams(): array|string
    {
        return [
            new SpecialParamKv(required: true),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
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
                <a-radio-group v-model="formData.{$this->getFieldName()}" :options='$options'"></a-radio-group>
            </a-form-item>
        code;
    }

    public function getMigrateCodeFragment(): string
    {
        $allowedValues = $this->innerGetConfigParam('kv', []);

        if (! is_array($allowedValues)) {
            return "enum('" . $this->field['field_name'] . "', [])";
        }

        $quotedValues = array_map(function ($value) {
            return is_string($value[1]) ? "'" . addslashes($value[1]) . "'" : $value[1];
        }, $allowedValues);

        $allowedStr = '[' . implode(', ', $quotedValues) . ']';

        return "enum('" . $this->field['field_name'] . "', " . $allowedStr . ')';
    }
}
