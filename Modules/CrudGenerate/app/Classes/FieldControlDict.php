<?php

namespace Modules\CrudGenerate\Classes;

use Modules\Admin\Services\SystemDictService;

class FieldControlDict extends AbstractFieldControl
{
    public function getSpecialParams(): array
    {
        return [
            new class extends AbstractSpecialParam
            {
                public function __construct()
                {
                    parent::__construct(
                        label: '字典',
                        name: 'dict_code',
                        inputComponent: 'dict-group-select',
                        placeholder: '请选择字典编码',
                        inputAttrs: ['style' => 'width: 220px'],
                    );
                }
            },
        ];
    }

    public function getMigrateCodeFragment(): string
    {
        $systemDictService = \app(SystemDictService::class);
        $dictCode          = $this->field['field_control_special_params']['dict_code'];
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
