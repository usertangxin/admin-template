<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlEnum extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamAllowed,
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        return '';
    }

}
