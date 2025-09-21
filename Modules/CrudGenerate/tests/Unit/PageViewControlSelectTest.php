<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlSelect;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlSelectTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(PageViewControlSelect::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'allow-clear'  => 'yes',
            'allow-search' => 'yes',
            'multiple'     => 'yes',
            'kv'           => [
                ['选项1', '1'],
                ['选项2', '2'],
            ],
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeFragment();
        $this->assertStringContainsString(' allow-clear', $fragment);
        $this->assertStringContainsString(' allow-search', $fragment);
        $this->assertStringContainsString(' multiple', $fragment);
        $this->assertStringContainsString(' :options="[{"label":"选项1","value":"1"},{"label":"选项2","value":"2"}]', $fragment);
    }
}
