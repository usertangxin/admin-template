<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlCheckBox extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamKv(required: true),
        ];
    }

    public function getQueryParams(): array|string
    {
        return [];
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $kv = $this->innerGetSpecialParam('kv', []);
        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-checkbox-group v-model="formData.{$this->getFieldName()}" :options='$options'"></a-checkbox-group>
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
