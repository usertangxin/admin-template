<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlUnsignedInteger;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class FieldControlUnsignedIntegerTest extends TestCase
{
    public function test_get_migrate_code_fragment_1()
    {
        $class = $this->app->make(FieldControlUnsignedInteger::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['autoIncrement' => 'yes']], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("unsignedInteger('aaa', true)", $fragment);
    }

    public function test_get_migrate_code_fragment_2()
    {
        $class = $this->app->make(FieldControlUnsignedInteger::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['autoIncrement' => 'no']], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("unsignedInteger('aaa', false)", $fragment);
    }

    public function test_get_migrate_code_fragment_3()
    {
        $class = $this->app->make(FieldControlUnsignedInteger::class);
        $class->make(['field_name' => 'aaa'], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("unsignedInteger('aaa', false)", $fragment);
    }
}
