<?php

namespace Modules\CrudGenerate\Classes;

use Modules\Admin\Services\SystemDictService;

class FieldControlDictCheckbox extends AbstractFieldControl
{
    public function getIndexQueryFragment(): string { 
        // TODO
        return '';
    }
    public function getConfigParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getFormCodeFragment(): string
    {

        $dictCode = $this->innerGetConfigParam('dict_code');

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <dict-checkbox v-model="formData.{$this->getFieldName()}" code="{$dictCode}"></dict-checkbox>
            </a-form-item>
        code;
    }

    public function getMigrateCodeFragment(): string
    {
        return 'json(\'' . $this->field['field_name'] . '\')';
    }
}
