<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlUnsignedBigInteger extends AbstractFieldControl
{
    public function getConfigParams(): array
    {
        return [
            new SpecialParamYesOrNo('是否自增', 'autoIncrement'),
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $autoIncrement = '';
        if ($autoIncrement = $this->innerGetSpecialParam('autoIncrement', 'no')) {
            $autoIncrement = ', ' . ($autoIncrement == 'yes' ? 'true' : 'false');
        }

        return 'unsignedBigInteger(\'' . $this->field['field_name'] . '\'' . $autoIncrement . ')';
    }
}
