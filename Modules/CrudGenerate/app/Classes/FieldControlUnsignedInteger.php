<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlUnsignedInteger extends AbstractFieldControl
{
    public function getSpecialParams(): array
    {
        return [
            new SpecialParamYesOrNo('是否自增', 'autoIncrement'),
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $autoIncrement = '';
        if (isset($this->field['field_control_special_params']['autoIncrement'])) {
            $autoIncrement = ', ' . ($this->field['field_control_special_params']['autoIncrement'] == 'yes' ? 'true' : 'false');
        }

        return 'unsignedInteger(\'' . $this->field['field_name'] . '\'' . $autoIncrement . ')';
    }
}
