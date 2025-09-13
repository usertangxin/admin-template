<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlUnsignedBigInteger extends AbstractFieldControl
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
            $autoIncrement = ', ' . ($this->field['field_control_special_params']['precision'] == 'yes' ? 'true' : 'false');
        }

        return 'unsignedBigInteger(\'' . $this->field['field_name'] . '\'' . $autoIncrement . ')';
    }
}
