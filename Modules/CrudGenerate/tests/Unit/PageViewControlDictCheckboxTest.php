<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlDictCheckbox;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlDictCheckboxTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(PageViewControlDictCheckbox::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'dict_code' => 'data_status',
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeHtmlFragment();
        $this->assertStringContainsString(' code="data_status"', $fragment);
    }
}
