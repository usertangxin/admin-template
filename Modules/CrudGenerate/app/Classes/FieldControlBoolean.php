<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlBoolean extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return 'boolean(\'' . $this->field['field_name'] . '\')';
    }
}
