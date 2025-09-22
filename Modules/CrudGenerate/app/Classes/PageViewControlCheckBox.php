<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlCheckBox extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamKv,
        ];
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
                <a-checkbox-group v-model="formData.{$this->getFieldName()}" :options='$options' placeholder="请输入{$this->getComment()}"></a-checkbox-group>
            </a-form-item>
        code;
    }
}
