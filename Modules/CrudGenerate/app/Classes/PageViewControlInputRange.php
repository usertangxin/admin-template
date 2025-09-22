<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlInputRange extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamInputRange,
            new SpecialParamPrecision,
            new SpecialParamStep,
        ];
    }

    public function getFormCodeFragment(): string
    {
        $attrs     = '';
        $range     = $this->innerGetSpecialParam('range', []);
        $precision = $this->innerGetSpecialParam('precision', null);
        $step      = $this->innerGetSpecialParam('step', null);
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
