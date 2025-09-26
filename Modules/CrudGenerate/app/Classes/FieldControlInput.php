<?php

namespace Modules\CrudGenerate\Classes;

class FieldControlInput extends AbstractFieldControl
{

    public function getConfigParams(): array|string
    {
        return <<<code
            <a-form-item label="字段类型" field="field_type">
                <a-radio-group v-model="params.field_type" code="field_type" default-value="string">
                    <a-radio value="string">string</a-radio>
                    <a-radio value="uuid">UUID</a-radio>
                    <a-radio value="text">text</a-radio>
                    <a-radio value="longText">longText</a-radio>
                </a-radio-group>
            </a-form-item>
            <a-form-item label="长度">
                <a-input-number v-model="params.length" mode="button" :precision="0" :step="1" :min="1" placeholder="请输入长度"/>
            </a-form-item>
            <a-form-item label="是否模糊查询" field="query_like">
                <dict-radio v-model="params.query_like" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
        code;
    }

    public function getMigrateCodeFragment(): string
    {
        $lengthStr = '';
        if ($length = $this->innerGetConfigParam('length', null)) {
            $lengthStr = ', ' . $length;
        }

        // TODO 其他类型
        return 'string(\'' . $this->field['field_name'] . '\'' . $lengthStr . ')';
    }

    public function getFormCodeFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-input v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
            </a-form-item>
        code;
    }

    public function getIndexQueryFragment(): string
    {
        return <<<code
            <search-col>
                <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                    <a-input v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
                </a-form-item>
            </search-col>
        code;
    }
}
