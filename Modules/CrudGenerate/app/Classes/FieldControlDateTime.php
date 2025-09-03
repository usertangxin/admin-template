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
        return '';
    }

}
