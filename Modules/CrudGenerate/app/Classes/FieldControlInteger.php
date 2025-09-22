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
        if ($autoIncrement = $this->innerGetSpecialParam('autoIncrement', 'no')) {
            $str = ', ' . ($autoIncrement == 'yes' ? 'true' : 'false');
        } else {
            $str = ', false';
        }
        if ($unsigned = $this->innerGetSpecialParam('unsigned', 'no')) {
            $str .= ', ' . ($unsigned == 'yes' ? 'true' : 'false');
        } else {
            $str .= ', false';
        }

        return 'integer(\'' . $this->field['field_name'] . '\'' . $str . ')';
    }
}
