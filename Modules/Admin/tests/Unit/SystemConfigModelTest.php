<?php

namespace Modules\Admin\Tests\Unit;

use Modules\Admin\Casts\AsPurifierClean;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Tests\AbstractAuthTestCase;

class SystemConfigModelTest extends AbstractAuthTestCase
{
    public function test_value_xss()
    {
        $config = SystemConfig::create([
            'group'      => 'asdf',
            'name'       => 'asdf',
            'key'        => 'asdf',
            'input_type' => 'text',
            'value_cast' => AsPurifierClean::class,
            'value'      => '<div onclick="alert(\'XSS\');">1</div><script>alert("XSS");</script>',
        ]);

        $this->assertEquals('<div>1</div>', $config->value);
    }
}
