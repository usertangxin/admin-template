<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlString;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class FieldControlStringTest extends TestCase
{
    public function test_get_migrate_code_fragment_1()
    {
        $class = $this->app->make(FieldControlString::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['length' => 100]], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("string('aaa', 100)", $fragment);
    }

    public function test_get_migrate_code_fragment_2()
    {
        $class = $this->app->make(FieldControlString::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => []], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("string('aaa')", $fragment);
    }
}
