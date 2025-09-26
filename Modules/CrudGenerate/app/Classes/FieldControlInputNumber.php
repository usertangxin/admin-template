<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlInputNumber extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamAllowedRadio('字段类型', 'field_type', ['integer', 'unsignedInteger', 'unsignedBigInteger', 'float', 'double', 'decimal'], defaultValue: 'integer'),
            new SpecialParamInputRange,
            new SpecialParamPrecision,
            new SpecialParamAllowedRadio('模式', 'mode', ['embed', 'button'], '请选择模式', defaultValue: 'embed'),
            new SpecialParamStep,
            new SpecialParamYesOrNo('是否自增', 'autoIncrement'),
            new SpecialParamYesOrNo('无符号', 'unsigned'),
            new SpecialParamYesOrNo('范围查询', 'range_query'),
        ];
    }

    public function getIndexQueryFragment(): string
    {
        // TODO
        return '';
    }

    public function getMigrateCodeFragment(): string
    {
        $str = '';
        if ($autoIncrement = $this->innerGetConfigParam('autoIncrement', 'no')) {
            $str = ', ' . ($autoIncrement == 'yes' ? 'true' : 'false');
        } else {
            $str = ', false';
        }
        if ($unsigned = $this->innerGetConfigParam('unsigned', 'no')) {
            $str .= ', ' . ($unsigned == 'yes' ? 'true' : 'false');
        } else {
            $str .= ', false';
        }

        // TODO 其他类型
        return 'integer(\'' . $this->field['field_name'] . '\'' . $str . ')';
    }

    public function getFormCodeFragment(): string
    {
        $attrs     = '';
        $range     = $this->innerGetConfigParam('range', []);
        $precision = $this->innerGetConfigParam('precision', null);
        $mode      = $this->innerGetConfigParam('mode', null);
        $step      = $this->innerGetConfigParam('step', null);

        if ($range) {
            $attrs .= " :min=\"{$range[0]}\" :max=\"{$range[1]}\"";
        }
        if ($precision) {
            $attrs .= " :precision=\"{$precision}\"";
        }
        if ($mode) {
            $attrs .= " mode=\"{$mode}\"";
        }
        if ($step) {
            $attrs .= " :step=\"{$step}\"";
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <a-input-number v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"$attrs></a-input-number>
            </a-form-item>
        code;
    }
}
