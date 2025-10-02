<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlInputNumber;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlInputNumberTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(PageViewControlInputNumber::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'range'     => [0, 100],
            'precision' => 1,
            'mode'      => 'button',
            'step'      => 1,
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeHtmlFragment();
        $this->assertStringContainsString(' :min="0" :max="100"', $fragment);
        $this->assertStringContainsString(' :precision="1"', $fragment);
        $this->assertStringContainsString(' mode="button"', $fragment);
        $this->assertStringContainsString(' :step="1"', $fragment);
    }
}
