<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlInputRange extends AbstractFieldControl
{
   
    public function getConfigParams(): array|string
    {
        return [
            new SpecialParamInputRange,
            new SpecialParamPrecision,
            new SpecialParamStep,
        ];
    }

    public function getIndexQueryFragment(): string
    {
        // TODO
        return '';
    }

    public function getMigrateCodeFragment(): string
    {
        return 'json(\'' . $this->field['field_name'] . '\')';
    }

    public function getFormCodeFragment(): string
    {
        $attrs     = '';
        $range     = $this->innerGetConfigParam('range', []);
        $precision = $this->innerGetConfigParam('precision', null);
        $step      = $this->innerGetConfigParam('step', null);
        if ($range) {
            $attrs .= " :min=\"{$range[0]}\" :max=\"{$range[1]}\"";
        }
        if ($precision) {
            $attrs .= " :precision=\"{$precision}\"";
        }
        if ($step) {
            $attrs .= " :step=\"{$step}\"";
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <input-range v-model="formData.{$this->getFieldName()}"$attrs></input-range>
            </a-form-item>
        code;
    }
}
