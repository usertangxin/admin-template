<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlSelect extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamKv,
            new SpecialParamYesOrNo('允许清除', 'allow-clear'),
            new SpecialParamYesOrNo('多选', 'multiple'),
            new SpecialParamYesOrNo('允许搜索', 'allow-search'),
        ];
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $kv          = $this->field['page_view_control_special_params']['kv'] ?? [];
        $allowClear  = $this->field['page_view_control_special_params']['allow-clear'] ?? 'no';
        $multiple    = $this->field['page_view_control_special_params']['multiple'] ?? 'no';
        $allowSearch = $this->field['page_view_control_special_params']['allow-search'] ?? 'no';
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
                <a-select v-model="formData.{$this->getFieldName()}" :options='$options' placeholder="请输入{$this->getComment()}"$attrs></a-select>
            </a-form-item>
        code;
    }
}
