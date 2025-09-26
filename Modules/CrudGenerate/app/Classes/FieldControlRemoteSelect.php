<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlRemoteSelect extends AbstractFieldControl
{
    public function getConfigParams(): array|string
    {
        return [
            new SpecialParamAllowedRadio('字段类型', 'field_type', ['string', 'uuid', 'text', 'longText','integer', 'unsignedInteger', 'unsignedBigInteger', 'float', 'double', 'decimal'], defaultValue: 'integer'),
            new SpecialParamInput('远程接口', 'url', placeholder: '请输入远程接口', required: true),
            new SpecialParamInput('标签字段', 'label-field', placeholder: '请输入标签字段'),
            new SpecialParamInput('值字段', 'value-field', placeholder: '请输入值字段'),
            new SpecialParamInput('数据字段', 'data-field', placeholder: '请输入数据字段'),
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('多选', 'multiple'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getIndexQueryFragment(): string {
        // TODO
        return '';
    }

    public function getMigrateCodeFragment(): string
    {
        // TODO 其他类型
        return 'string(\'' . $this->field['field_name'] . '\')';
    }

    public function getQueryParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getFormCodeFragment(): string
    {

        $url         = $this->innerGetConfigParam('url', '');
        $labelField  = $this->innerGetConfigParam('label-field', 'name');
        $valueField  = $this->innerGetConfigParam('value-field', 'id');
        $dataField   = $this->innerGetConfigParam('data-field', 'data');
        $allowClear  = $this->innerGetConfigParam('allow-clear', 'no');
        $multiple    = $this->innerGetConfigParam('multiple', 'no');
        $allowSearch = $this->innerGetConfigParam('allow-search', 'no');
        $attrs       = '';

        $attrs .= " url=\"{$url}\"";
        $attrs .= " label-field=\"{$labelField}\"";
        $attrs .= " value-field=\"{$valueField}\"";
        $attrs .= " data-field=\"{$dataField}\"";

        if ($allowClear === 'yes') {
            $attrs .= ' allow-clear';
        }

        if ($multiple === 'yes') {
            $attrs .= ' multiple';
        }

        if ($allowSearch === 'yes') {
            $attrs .= ' allow-search';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <remote-select v-model="formData.{$this->getFieldName()}" placeholder="请搜索选择{$this->getComment()}"$attrs></remote-select>
            </a-form-item>
        code;
    }
}
