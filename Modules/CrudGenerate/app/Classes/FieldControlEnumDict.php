<?php

namespace Modules\CrudGenerate\Classes;

use Modules\Admin\Services\SystemDictService;

class FieldControlEnumDict extends AbstractFieldControl
{
    public function getConfigParams(): array
    {
        return [
            new SpecialParamDictGroupSelect(required: true),
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $systemDictService = \app(SystemDictService::class);
        $dictCode          = $this->innerGetSpecialParam('dict_code');
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
