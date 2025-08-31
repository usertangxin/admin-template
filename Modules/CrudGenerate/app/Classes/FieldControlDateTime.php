<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlDateTime implements FieldControl
{
    public function getLabel(): string
    {
        return 'dateTime';
    }

    public function getName(): string
    {
        return 'dateTime';
    }

    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamPrecision(),
        ];
    }

    public function getMigrateCodeFragment($filed, $allFields, $crudHistory): string
    {
        return '';
    }
}
