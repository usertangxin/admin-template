<?php

namespace Modules\CrudGenerate\Classes;

use Modules\Admin\Services\SystemDictService;

class FieldControlDictRadio extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getIndexQueryFragment(): string
    {
        // TODO
        return '';
    }

    public function getFormCodeFragment(): string
    {

        $dictCode = $this->innerGetConfigParam('dict_code');

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <dict-radio v-model="formData.{$this->getFieldName()}" code="{$dictCode}"></dict-radio>
            </a-form-item>
        code;
    }

    public function getMigrateCodeFragment(): string
    {
        $systemDictService = \app(SystemDictService::class);
        $dictCode          = $this->innerGetConfigParam('dict_code');
        $allowedValues     = $systemDictService->getValuesByCode($dictCode)->toArray();

        // 3. 将数组元素转换为带单引号的字符串（处理字符串/数字类型元素）
        $quotedValues = array_map(function ($value) {
            // 对字符串值转义单引号（避免SQL语法错误），数字类型直接保留
            return is_string($value) ? "'" . addslashes($value) . "'" : $value;
        }, $allowedValues);

        // 4. 拼接数组为逗号分隔的字符串，生成最终枚举语法
        $allowedStr = '[' . implode(', ', $quotedValues) . ']';

        return "enum('" . $this->field['field_name'] . "', " . $allowedStr . ')';
    }
}
