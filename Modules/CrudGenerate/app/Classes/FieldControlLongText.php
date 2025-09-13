<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlLongText extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return 'longText(\'' . $this->field['field_name'] . '\')';
    }
}
