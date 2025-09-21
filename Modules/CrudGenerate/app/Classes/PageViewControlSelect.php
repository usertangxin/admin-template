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
        $allowClear  = $this->field['page_view_control_special_params']['allow-clear'] ?? false;
        $multiple    = $this->field['page_view_control_special_params']['multiple'] ?? false;
        $allowSearch = $this->field['page_view_control_special_params']['allow-search'] ?? false;
        $attrs       = '';

        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        if ($allowClear) {
            $attrs .= ' allow-clear';
        }

        if ($multiple) {
            $attrs .= ' multiple';
        }

        if ($allowSearch) {
            $attrs .= ' allow-search';
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-select v-model="formData.{$this->getFieldName()}" :options="$options" placeholder="请输入{$this->getComment()}"$attrs></a-select>
            </a-form-item>
        code;
    }
}
