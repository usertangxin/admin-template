<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlEnum implements FieldControl
{
    public function getLabel(): string
    {
        return 'enum';
    }

    public function getName(): string
    {
        return 'enum';
    }

    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamAllowed(),
        ];
    }

    public function getMigrateCodeFragment($filed, $allFields, $crudHistory): string
    {
        return '';
    }
}
