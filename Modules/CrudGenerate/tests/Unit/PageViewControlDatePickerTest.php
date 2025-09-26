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

        $fragment = $class->getFormCodeFragment();

        foreach ($expectedStrings as $expected) {
            $this->assertStringContainsString($expected, $fragment);
        }
    }

    public static function formCodeFragmentProvider()
    {
        return [
            'date picker basic' => [
                ['type' => 'date', 'use_panel' => 'no', 'is_range' => 'no'],
                ['a-date-picker'],
            ],
            'datetime picker with time' => [
                ['type' => 'datetime', 'use_panel' => 'no', 'is_range' => 'no'],
                [' show-time'],
            ],
            'month picker basic' => [
                ['type' => 'month', 'use_panel' => 'no', 'is_range' => 'no'],
                ['a-month-picker'],
            ],
            'year picker basic' => [
                ['type' => 'year', 'use_panel' => 'no', 'is_range' => 'no'],
                ['a-year-picker'],
            ],
            'week picker basic' => [
                ['type' => 'week', 'use_panel' => 'no', 'is_range' => 'no'],
                ['a-week-picker'],
            ],
            'date picker with panel' => [
                ['type' => 'date', 'use_panel' => 'yes', 'is_range' => 'no'],
                [' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
            'datetime picker with panel' => [
                ['type' => 'datetime', 'use_panel' => 'yes', 'is_range' => 'no'],
                [' show-time', ' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
            'month picker with panel' => [
                ['type' => 'month', 'use_panel' => 'yes', 'is_range' => 'no'],
                ['a-month-picker', ' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
            'date range picker with panel' => [
                ['type' => 'date', 'use_panel' => 'yes', 'is_range' => 'yes'],
                ['a-range-picker', ' v-model:pickerValue="formData.aaa"', ' hide-trigger'],
            ],
            'year range picker' => [
                ['type' => 'year', 'use_panel' => 'no', 'is_range' => 'yes'],
                ['a-range-picker', ' mode="year"'],
            ],
        ];
    }
}
