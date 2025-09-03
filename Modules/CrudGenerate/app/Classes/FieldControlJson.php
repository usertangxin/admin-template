<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlJson extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return '';
    }
}
