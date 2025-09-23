<?php

namespace Modules\CrudGenerate\Classes;

use JsonSerializable;
use Modules\CrudGenerate\Interfaces\SpecialParam;

abstract class AbstractSpecialParam implements JsonSerializable, SpecialParam
{
    public function __construct(
        protected string $label,
        protected string $name,
        protected string $inputComponent,
        protected string $placeholder = '',
        protected array $inputAttrs = [],
        protected mixed $defaultValue = null,
        protected bool $required = false,
    ) {}

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInputComponent(): string
    {
        return $this->inputComponent;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getInputAttrs(): array
    {
        return $this->inputAttrs;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function jsonSerialize(): array
    {
        return [
            'label'          => $this->label,
            'name'           => $this->name,
            'inputComponent' => $this->inputComponent,
            'placeholder'    => $this->placeholder,
            'inputAttrs'     => $this->inputAttrs,
            'defaultValue'   => $this->defaultValue,
            'required'       => $this->required,
        ];
    }
}
