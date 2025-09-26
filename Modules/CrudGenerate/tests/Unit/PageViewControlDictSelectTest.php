<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlDictSelect;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlDictSelectTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(PageViewControlDictSelect::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'allow-clear'  => 'yes',
            'allow-search' => 'yes',
            'multiple'     => 'yes',
            'dict_code'    => 'yes_or_no',
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeFragment();
        $this->assertStringContainsString(' allow-clear', $fragment);
        $this->assertStringContainsString(' allow-search', $fragment);
        $this->assertStringContainsString(' multiple', $fragment);
        $this->assertStringContainsString(' code="yes_or_no"', $fragment);
    }
}
