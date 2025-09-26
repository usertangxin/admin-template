<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlRate extends AbstractFieldControl
{
    public function getConfigParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('半选', 'allow-half', defaultValue: 'no'),
            new SpecialParamLength('长度', 'count', defaultValue: 5),
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
        return 'unsignedInteger(\'' . $this->field['field_name'] . '\')';
    }

    public function getFormCodeFragment(): string
    {
        $attrs     = '';
        $count     = $this->innerGetConfigParam('count', null);
        $allowHalf = $this->innerGetConfigParam('allow-half', 'no');
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
