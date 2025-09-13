<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlText extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return 'text(\'' . $this->field['field_name'] . '\')';
    }
}
