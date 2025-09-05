<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlJson extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return 'json(\'' . $this->field['field_name'] . '\')';
    }
}
