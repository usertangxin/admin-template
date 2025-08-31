<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlString implements FieldControl
{
    public function getLabel(): string
    {
        return 'string';
    }

    public function getName(): string
    {
        return 'string';
    }

    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamLength(),
        ];
    }

    public function getMigrateCodeFragment($filed, $allFields, $crudHistory): string
    {
        return '';
    }
}
