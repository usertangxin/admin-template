<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlRemoteSelect extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamInput('远程接口', 'url', placeholder: '请输入远程接口', required: true),
            new SpecialParamInput('标签字段', 'label-field', placeholder: '请输入标签字段'),
            new SpecialParamInput('值字段', 'value-field', placeholder: '请输入值字段'),
            new SpecialParamInput('数据字段', 'data-field', placeholder: '请输入数据字段'),
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
        ];
    }

    public function getQueryParams(): array|string
    {
        return [];
    }

    public function getQueryScopeFragment(): string
    {

        if ($this->innerGetSpecialParam('multiple', 'no') != 'yes') {
            return '';
        }

        $name = Str::studly($this->getFieldName());

        return <<<code
            protected function scope{$name}(Builder \$query, \$value)
            {
                \$query->whereJsonContains('{$this->getFieldName()}', \$value);
            }
        code;
    }

    public function getFormCodeHtmlFragment(): string
    {

        $url         = $this->innerGetSpecialParam('url', '');
        $labelField  = $this->innerGetSpecialParam('label-field', 'name');
        $valueField  = $this->innerGetSpecialParam('value-field', 'id');
        $dataField   = $this->innerGetSpecialParam('data-field', 'data');
        $allowClear  = $this->innerGetSpecialParam('allow-clear', 'no');
        $multiple    = $this->innerGetSpecialParam('multiple', 'no');
        $allowSearch = $this->innerGetSpecialParam('allow-search', 'no');
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
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <remote-select v-model="formData.{$this->getFieldName()}" placeholder="请搜索选择{$this->getComment()}"$attrs></remote-select>
            </a-form-item>
        code;
    }

    public function getFormCodeDefaultValue()
    {
        if ($this->innerGetSpecialParam('multiple', 'no') != 'yes') {
            return null;
        }
        return [];
    }

    public function getIndexQueryHtmlFragment(): string
    {
        $attrs = ' allow-clear allow-search';

        $url        = $this->innerGetSpecialParam('url', '');
        $labelField = $this->innerGetSpecialParam('label-field', 'name');
        $valueField = $this->innerGetSpecialParam('value-field', 'id');
        $dataField  = $this->innerGetSpecialParam('data-field', 'data');

        $attrs .= " url=\"{$url}\"";
        $attrs .= " label-field=\"{$labelField}\"";
        $attrs .= " value-field=\"{$valueField}\"";
        $attrs .= " data-field=\"{$dataField}\"";

        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <remote-select v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请搜索选择{$this->getComment()}"$attrs></remote-select>
                </a-form-item>
            </search-col>
        code;
    }
}
