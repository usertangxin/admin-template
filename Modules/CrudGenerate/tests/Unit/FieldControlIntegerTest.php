<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlInteger;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FieldControlIntegerTest extends TestCase
{
    /**
     * 测试整数字段的迁移代码生成逻辑
     *
     * @param array  $specialParams    字段特殊参数（autoIncrement/unsigned）
     * @param string $expectedFragment 预期的迁移代码片段
     */
    #[DataProvider('migrateCodeFragmentProvider')]
    public function test_get_migrate_code_fragment(array $specialParams, string $expectedFragment)
    {
        // 1. 初始化类实例（提取重复逻辑）
        $integerControl = $this->app->make(FieldControlInteger::class);
        $integerControl->make(
            [
                'field_name'                   => 'aaa',       // 固定字段名，所有测试用例一致
                'field_control_special_params' => $specialParams,
            ],
            [],
            new SystemCrudHistory
        );

        // 2. 执行测试并断言
        $actualFragment = $integerControl->getMigrateCodeFragment();
        $this->assertEquals($expectedFragment, $actualFragment);
    }

    /**
     * 数据提供者：整数字段迁移代码的测试场景
     * 格式：[ [特殊参数], 预期结果 ]
     */
    public static function migrateCodeFragmentProvider(): array
    {
        return [
            // 场景1：自动递增 + 无符号
            'autoIncrement yes + unsigned yes' => [
                ['autoIncrement' => 'yes', 'unsigned' => 'yes'],
                "integer('aaa', true, true)",
            ],
            // 场景2：仅自动递增
            'autoIncrement yes + unsigned no' => [
                ['autoIncrement' => 'yes'],
                "integer('aaa', true, false)",
            ],
            // 场景3：仅无符号
            'autoIncrement no + unsigned yes' => [
                ['unsigned' => 'yes'],
                "integer('aaa', false, true)",
            ],
            // 场景4：无特殊参数（默认）
            'autoIncrement no + unsigned no' => [
                [],  // 空参数
                "integer('aaa', false, false)",
            ],
        ];
    }
}
