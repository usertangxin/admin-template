<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlTimePicker;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlTimePickerTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(PageViewControlTimePicker::class);
        $class->make([
            'field_name'                       => 'aaa',
            'comment'                          => '测试',
            'page_view_control_special_params' => ['is_range' => 'no'],
        ], [], new SystemCrudHistory);

        $fragment = $class->getFormCodeHtmlFragment();

        $this->assertStringContainsString('a-time-picker', $fragment);
    }

    public function test_get_form_code_fragment_with_step()
    {
        $class = $this->app->make(PageViewControlTimePicker::class);
        $class->make([
            'field_name'                       => 'aaa',
            'comment'                          => '测试',
            'page_view_control_special_params' => ['disable_confirm' => 'yes', 'is_range' => 'yes', 'step_hour' => 2],
        ], [], new SystemCrudHistory);

        $fragment = $class->getFormCodeHtmlFragment();

        $this->assertStringContainsString(' :step="{hour: 2, minute: 1, second: 1}"', $fragment);
        $this->assertStringContainsString(' type="time-range"', $fragment);
        $this->assertStringContainsString(' :disable-confirm="true"', $fragment);
    }
}
