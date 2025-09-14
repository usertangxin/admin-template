<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlInteger;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class FieldControlIntegerTest extends TestCase
{
    public function test_get_migrate_code_fragment_1()
    {
        $class = $this->app->make(FieldControlInteger::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['autoIncrement' => 'yes', 'unsigned' => 'yes']], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("integer('aaa', true, true)", $fragment);
    }

    public function test_get_migrate_code_fragment_2()
    {
        $class = $this->app->make(FieldControlInteger::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['autoIncrement' => 'yes']], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("integer('aaa', true, false)", $fragment);
    }

    public function test_get_migrate_code_fragment_3()
    {
        $class = $this->app->make(FieldControlInteger::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['unsigned' => 'yes']], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("integer('aaa', false, true)", $fragment);
    }

    public function test_get_migrate_code_fragment_4()
    {
        $class = $this->app->make(FieldControlInteger::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => []], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("integer('aaa', false, false)", $fragment);
    }
}
