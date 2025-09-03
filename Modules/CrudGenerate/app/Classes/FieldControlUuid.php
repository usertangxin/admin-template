<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlUuid implements FieldControl
{
    public function getLabel(): string
    {
        return 'uuid';
    }

    public function getName(): string
    {
        return 'uuid';
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