<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlSelect extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamKv(required: true),
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('多选', 'multiple'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
        ];
    }

    public function getQueryParams(): array|string
    {
        return [];
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $kv          = $this->innerGetSpecialParam('kv', []);
        $allowClear  = $this->innerGetSpecialParam('allow-clear', 'no');
        $multiple    = $this->innerGetSpecialParam('multiple', 'no');
        $allowSearch = $this->innerGetSpecialParam('allow-search', 'no');
        $attrs       = '';

        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

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
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-select v-model="formData.{$this->getFieldName()}" :options='$options' placeholder="请选择{$this->getComment()}"$attrs></a-select>
            </a-form-item>
        code;
    }

    public function getIndexQueryFragment(): string
    {
        $options = [];

        $kv = $this->innerGetSpecialParam('kv', []);
        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return <<<code
            <search-col>
                <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                     <a-select v-model="store.searchQuery.{$this->getFieldName()}" :options='$options'"></a-select>
                </a-form-item>
            </search-col>
        code;
    }
}
