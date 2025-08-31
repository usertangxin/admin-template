<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlJson implements FieldControl
{
    public function getLabel(): string
    {
        return 'json';
    }

    public function getName(): string
    {
        return 'json';
    }

    public function getSpecialParams(): array|string
    {
        return [];
    }

    public function getMigrateCodeFragment($filed, $allFields, $crudHistory): string {
        return '';
    }
}
