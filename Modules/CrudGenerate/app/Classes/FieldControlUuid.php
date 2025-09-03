<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlUuid extends AbstractFieldControl
{
    public function getMigrateCodeFragment(): string
    {
        $field_name = $this->field['field_name'];

        return "uuid('$field_name')";
    }

    public function getModelUseTraits(): array
    {
        return [
            HasUuids::class,
        ];
    }
}
