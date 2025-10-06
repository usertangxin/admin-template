<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlDatePicker;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageViewControlDatePickerTest extends TestCase
{
    #[DataProvider('formCodeFragmentProvider')]
    public function test_get_form_code_fragment(array $params, array $expectedStrings)
    {
        $class = $this->app->make(PageViewControlDatePicker::class);
        $class->make([
            'field_name'                       => 'aaa',
            'comment'                          => '测试',
            'page_view_control_special_params' => $params,
        ], [], new SystemCrudHistory);

        $fragment = $class->getFormCodeHtmlFragment();

        foreach ($expectedStrings as $expected) {
            $this->assertStringContainsString($expected, $fragment);
        }
    }

    public static function formCodeFragmentProvider()
    {
        return [
            'date picker basic' => [
                ['type' => 'date', 'use_panel' => 'no'],
                ['a-date-picker'],
            ],
            'datetime picker with time' => [
                ['type' => 'datetime', 'use_panel' => 'no'],
                [' show-time'],
            ],
            'month picker basic' => [
                ['type' => 'month', 'use_panel' => 'no'],
                ['a-month-picker'],
            ],
            'year picker basic' => [
                ['type' => 'year', 'use_panel' => 'no'],
                ['a-year-picker'],
            ],
            'week picker basic' => [
                ['type' => 'week', 'use_panel' => 'no'],
                ['a-week-picker'],
            ],
            'date picker with panel' => [
                ['type' => 'date', 'use_panel' => 'yes'],
                [' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
            'datetime picker with panel' => [
                ['type' => 'datetime', 'use_panel' => 'yes'],
                [' show-time', ' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
            'month picker with panel' => [
                ['type' => 'month', 'use_panel' => 'yes'],
                ['a-month-picker', ' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
        ];
    }
}
