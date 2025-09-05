<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;
use Modules\CrudGenerate\Interfaces\FieldControl;
use Modules\CrudGenerate\Models\SystemCrudHistory;

abstract class AbstractFieldControl implements FieldControl
{
    protected array $field;

    protected array $allFields;

    protected SystemCrudHistory $crudHistory;

    public function make(array $field, array $allFields, SystemCrudHistory $crudHistory): void
    {
        $this->field       = $field;
        $this->allFields   = $allFields;
        $this->crudHistory = $crudHistory;
    }

    public function getLabel(): string
    {
        return Str::studly(\str_replace('FieldControl', '', \class_basename($this)));
    }

    public function getName(): string
    {
        return Str::studly(\str_replace('FieldControl', '', \class_basename($this)));
    }

    public function getSpecialParams(): array
    {
        return [];
    }

    public function getModelUseTraits(): array
    {
        return [];
    }
}
