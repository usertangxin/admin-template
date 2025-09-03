<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlDateTime extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamPrecision,
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $precisionStr = '';
        if (isset($this->field['field_control_special_params']['precision'])) {
            $precisionStr = ', ' . $this->field['field_control_special_params']['precision'];
        }
        return 'dateTime(\'' . $this->field['field_name'] . '\''. $precisionStr .')';
    }

}
