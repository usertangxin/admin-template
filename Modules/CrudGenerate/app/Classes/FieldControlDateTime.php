<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlDateTime extends AbstractFieldControl
{
    public function getConfigParams(): array
    {
        return [
            new SpecialParamPrecision,
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $precisionStr = '';
        if ($precision = $this->innerGetSpecialParam('precision')) {
            $precisionStr = ', ' . $precision;
        }

        return 'dateTime(\'' . $this->field['field_name'] . '\'' . $precisionStr . ')';
    }
}
