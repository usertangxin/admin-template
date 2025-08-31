<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlBoolean implements FieldControl
{
    public function getLabel(): string
    {
        return 'boolean';
    }

    public function getName(): string
    {
        return 'boolean';
    }

    public function getSpecialParams(): array|string
    {
        return [];
    }

    public function getMigrateCodeFragment($filed, $allFields, $crudHistory): string
    {
        return '';
    }
}
