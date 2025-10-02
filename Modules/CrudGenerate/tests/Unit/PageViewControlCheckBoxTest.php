<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlCheckBox;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlCheckBoxTest extends TestCase
{
    public function test_get_form_code_fragment(): void
    {
        $class = $this->app->make(PageViewControlCheckBox::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'kv' => [
                ['选项1', '1'],
                ['选项2', '2'],
            ],
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeHtmlFragment();
        $this->assertStringContainsString(' :options=\'[{"label":"选项1","value":"1"},{"label":"选项2","value":"2"}]\'', $fragment);
    }
}
