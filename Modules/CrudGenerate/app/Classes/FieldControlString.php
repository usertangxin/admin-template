<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlString extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamLength,
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        return '';
    }
}
