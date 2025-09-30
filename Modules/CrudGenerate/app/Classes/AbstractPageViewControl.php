<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;
use Modules\CrudGenerate\Interfaces\PageViewControl;
use Modules\CrudGenerate\Models\SystemCrudHistory;

abstract class AbstractPageViewControl implements PageViewControl
{
    protected SystemCrudHistory $crudHistory;

    protected array $field;

    protected array $allFields;

    public function make(array $field, array $allFields, SystemCrudHistory $crudHistory)
    {
        $this->field       = $field;
        $this->allFields   = $allFields;
        $this->crudHistory = $crudHistory;
    }

    public function getLabel(): string
    {
        return Str::studly(\str_replace('PageViewControl', '', \class_basename($this)));
    }

    public function getName(): string
    {
        return Str::studly(\str_replace('PageViewControl', '', \class_basename($this)));
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

    public function getQueryParams(): array|string
    {
        return [];
    }

    protected function innerGetSpecialParam(string $name, mixed $default = null)
    {
        return $this->field['page_view_control_special_params'][$name] ?? $default;
    }

    protected function innerGetQueryParam(string $name, mixed $default = null)
    {
        return $this->field['page_view_control_query_params'][$name] ?? $default;
    }

    public function getIndexColumnFragment(): array
    {
        return [];
    }

    public function getFormImportFragment(): array
    {
        return [];
    }

    // public function getIndexQueryFragment(): string
    // {
    //     return '';
    // }

    public function getModelCast(): ?string
    {
        return null;
    }

    public function getRequestRules(): null|array|string
    {
        return null;
    }
}
