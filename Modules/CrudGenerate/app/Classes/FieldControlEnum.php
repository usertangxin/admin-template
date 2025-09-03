<?php

namespace Modules\CrudGenerate\Classes;

use Modules\CrudGenerate\Interfaces\FieldControl;

class FieldControlEnum extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamAllowed,
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        // 1. 提取allowed数组并做默认值处理（避免未定义报错）
        $allowedValues = $this->field['field_control_special_params']['allowed'] ?? [];

        // 2. 校验是否为有效数组，非数组则返回空枚举（或根据业务需求调整默认值）
        if (!is_array($allowedValues)) {
            return "enum('" . $this->field['field_name'] . "', [])";
        }

        // 3. 将数组元素转换为带单引号的字符串（处理字符串/数字类型元素）
        $quotedValues = array_map(function ($value) {
            // 对字符串值转义单引号（避免SQL语法错误），数字类型直接保留
            return is_string($value) ? "'" . addslashes($value) . "'" : $value;
        }, $allowedValues);

        // 4. 拼接数组为逗号分隔的字符串，生成最终枚举语法
        $allowedStr = '[' . implode(', ', $quotedValues) . ']';

        return "enum('" . $this->field['field_name'] . "', " . $allowedStr . ")";
    }

}
