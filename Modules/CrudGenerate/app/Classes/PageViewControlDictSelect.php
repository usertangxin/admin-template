<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Support\Str;

class PageViewControlDictSelect extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('多选', 'multiple'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
        ];
    }

    public function getRequestRules(): null|array|string
    {
        $dictCode = $this->innerGetSpecialParam('dict_code');

        $a = ['in_dict:' . $dictCode];

        if ($this->innerGetSpecialParam('multiple', 'no') == 'yes') {
            $a[] = 'array';
        }

        return $a;
    }

    public function getModelCast(): ?string
    {
        if ($this->innerGetSpecialParam('multiple', 'no') != 'yes') {
            return null;
        }

        return AsArrayObject::class;
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

    public function getFormCodeDefaultValue()
    {
        if ($this->innerGetSpecialParam('multiple', 'no') != 'yes') {
            return null;
        }
        return [];
    }

    public function getFormCodeHtmlFragment(): string
    {
        $options = [];

        $dictCode    = $this->innerGetSpecialParam('dict_code');
        $allowClear  = $this->innerGetSpecialParam('allow-clear', 'no');
        $multiple    = $this->innerGetSpecialParam('multiple', 'no');
        $allowSearch = $this->innerGetSpecialParam('allow-search', 'no');
        $attrs       = '';

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

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
                <dict-select v-model="formData.{$this->getFieldName()}" code="{$dictCode}" placeholder="请输入{$this->getComment()}"$attrs></dict-select>
            </a-form-item>
        code;
    }

    public function getIndexQueryHtmlFragment(): string
    {
        $dictCode = $this->innerGetSpecialParam('dict_code');

        $attrs = '  allow-clear allow-search';

        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <dict-select v-model="store.searchQuery.{$this->getFieldName()}" code="{$dictCode}" placeholder="请选择{$this->getComment()}"$attrs></dict-select>
                </a-form-item>
             </search-col>
         code;
    }
}
