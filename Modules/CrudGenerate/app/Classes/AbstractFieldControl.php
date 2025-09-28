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

    public function getFieldName()
    {
        return $this->field['field_name'];
    }

    public function getComment()
    {
        return $this->field['comment'];
    }

    public function getSpecialParams(): array|string
    {
        return [];
    }

    protected function innerGetSpecialParam(string $name, mixed $default = null)
    {
        return $this->field['field_control_special_params'][$name] ?? $default;
    }

    public function getModelUseTraits(): array
    {
        return [];
    }
}
