<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlDateTime;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class FieldControlDateTimeTest extends TestCase
{
    public function test_fragment_1()
    {
        $class = $this->app->make(FieldControlDateTime::class);
        $class->make(['field_name' => 'created_at', 'field_control_special_params'=>['precision' => 3]],[], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals('dateTime(\'created_at\', 3)', $fragment);
    }

    public function test_fragment_2()
    {
        $class = $this->app->make(FieldControlDateTime::class);
        $class->make(['field_name' => 'created_at', 'field_control_special_params' => []], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals('dateTime(\'created_at\')', $fragment);
    }
}
