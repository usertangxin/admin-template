<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlRate;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlRateTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(FieldControlRate::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'count'      => 5,
            'allow-half' => 'yes',
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeFragment();
        $this->assertStringContainsString(' :count="5"', $fragment);
        $this->assertStringContainsString(' :allow-half="true"', $fragment);
    }
}
