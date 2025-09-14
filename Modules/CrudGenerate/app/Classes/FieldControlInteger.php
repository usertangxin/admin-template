<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlInteger extends AbstractFieldControl
{
    public function getSpecialParams(): array
    {
        return [
            new SpecialParamYesOrNo('是否自增', 'autoIncrement'),
            new SpecialParamYesOrNo('无符号', 'unsigned'),
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $str = '';
        if (isset($this->field['field_control_special_params']['autoIncrement'])) {
            $str = ', ' . ($this->field['field_control_special_params']['autoIncrement'] == 'yes' ? 'true' : 'false');
        } else {
            $str = ', false';
        }
        if (isset($this->field['field_control_special_params']['unsigned'])) {
            $str .= ', ' . ($this->field['field_control_special_params']['unsigned'] == 'yes' ? 'true' : 'false');
        } else {
            $str .= ', false';
        }

        return 'integer(\'' . $this->field['field_name'] . '\'' . $str . ')';
    }
}
