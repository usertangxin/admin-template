<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;
use Modules\CrudGenerate\Interfaces\QueryViewControl;
use Modules\CrudGenerate\Models\SystemCrudHistory;

abstract class AbstractQueryViewControl implements QueryViewControl
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
        return Str::studly(\str_replace('QueryViewControl', '', \class_basename($this)));
    }

    public function getName(): string
    {
        return Str::studly(\str_replace('QueryViewControl', '', \class_basename($this)));
    }

    public function getSpecialParams(): array|string
    {
        return [];
    }

    protected function innerGetSpecialParam(string $name, mixed $default = null)
    {
        return $this->field['query_view_control_special_params'][$name] ?? $default;
    }
}
