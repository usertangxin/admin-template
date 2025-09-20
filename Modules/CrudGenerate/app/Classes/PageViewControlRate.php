<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlRate extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('半选', 'allow-half', defaultValue: 'no'),
            new SpecialParamLength('长度', 'count', defaultValue: 5),
        ];
    }

    public function getFormCodeFragment(): string
    {
        $attrs     = '';
        $count     = $this->field['page_view_control_special_params']['count'] ?? null;
        $allowHalf = $this->field['page_view_control_special_params']['allow-half'] ?? 'no';
        if ($count) {
            $attrs .= " :count=\"$count\"";
        }
        if ($allowHalf === 'yes') {
            $attrs .= ' :allow-half="true"';
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <a-rate v-model="formData.{$this->getFieldName()}"$attrs></a-rate>
            </a-form-item>
        code;
    }
}
