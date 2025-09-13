<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlBigIncrements extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        return 'bigIncrements(\'' . $this->field['field_name'] . '\')';
    }
}
