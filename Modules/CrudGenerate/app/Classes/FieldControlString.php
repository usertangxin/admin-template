<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlString extends AbstractFieldControl
{
    public function getSpecialParams(): array
    {
        return [
            new SpecialParamLength,
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $lengthStr = '';
        if (isset($this->field['field_control_special_params']['length'])) {
            $lengthStr = '\', ' . $this->field['field_control_special_params']['length'];
        }

        return 'string(\'' . $this->field['field_name'] . $lengthStr . ')';
    }
}
