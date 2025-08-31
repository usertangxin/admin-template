<?php

namespace Modules\CrudGenerate\Interfaces;

interface SpecialParam
{
    public function getLabel(): string;

    public function getName(): string;

    public function getInputComponent(): string;

    public function getPlaceholder(): string;

    public function getInputAttrs(): array;

    public function getDefaultValue(): mixed;
}
