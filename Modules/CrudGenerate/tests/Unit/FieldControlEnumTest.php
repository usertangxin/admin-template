<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlEnum;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class FieldControlEnumTest extends TestCase
{
    public function test_get_migrate_code_fragment_1()
    {
        $class = $this->app->make(FieldControlEnum::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => []], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals('enum(\'aaa\', [])', $fragment);
    }

    public function test_get_migrate_code_fragment_2()
    {
        $class = $this->app->make(FieldControlEnum::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['allowed' => ['a', 'b', 'c']]], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("enum('aaa', ['a', 'b', 'c'])", $fragment);
    }
}
