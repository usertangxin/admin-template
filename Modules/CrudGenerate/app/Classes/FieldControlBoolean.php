<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlBoolean extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return '';
    }
}
