<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\CrudGenerate\Classes\FieldControlEnumDict;
use Modules\CrudGenerate\Models\SystemCrudHistory;

class FieldControlEnumDictTest extends AbstractAuthTestCase
{
    public function test_get_migrate_code_fragment()
    {
        $class = $this->app->make(FieldControlEnumDict::class);
        $class->make(['field_name' => 'aaa', 'field_control_special_params' => ['dict_code' => 'yes_or_no']], [], new SystemCrudHistory);
        $fragment = $class->getMigrateCodeFragment();
        $this->assertEquals("enum('aaa', ['yes', 'no'])", $fragment);
    }
}
