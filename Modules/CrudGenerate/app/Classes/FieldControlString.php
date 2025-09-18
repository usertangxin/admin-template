<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlString extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        // return [
        //     new SpecialParamLength,
        // ];
        return <<<'CODE'
<a-form-item label="长度">
    <a-input-number v-model="params.length" mode="button" :precision="0" :step="1" :min="1" :max="255" placeholder="请输入长度"/>
</a-form-item>
CODE;
    }

    public function getMigrateCodeFragment(): string
    {
        $lengthStr = '';
        if (isset($this->field['field_control_special_params']['length'])) {
            $lengthStr = ', ' . $this->field['field_control_special_params']['length'];
        }

        return 'string(\'' . $this->field['field_name'] . '\'' . $lengthStr . ')';
    }
}
