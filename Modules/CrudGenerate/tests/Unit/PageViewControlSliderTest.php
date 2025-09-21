<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlSlider;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Tests\TestCase;

class PageViewControlSliderTest extends TestCase
{
    public function test_get_form_code_fragment()
    {
        $class = $this->app->make(PageViewControlSlider::class);
        $class->make(['field_name' => 'aaa', 'comment' => '测试', 'page_view_control_special_params' => [
            'range-value' => [0, 150],
            'step'        => 2,
            'range'       => 'yes',
            'show-ticks'  => 'yes',
            'show-input'  => 'yes',
            'marks'       => [
                ['不爽', 0],
                ['有点爽', 50],
                ['很爽', 100],
                ['超爽', 150],
            ],
        ]], [], new SystemCrudHistory);
        $fragment = $class->getFormCodeFragment();
        $this->assertStringContainsString(' :step="2"', $fragment);
        $this->assertStringContainsString(' :min="0"', $fragment);
        $this->assertStringContainsString(' :max="150"', $fragment);
        $this->assertStringContainsString(' range', $fragment);
        $this->assertStringContainsString(' show-ticks', $fragment);
        $this->assertStringContainsString(' show-input', $fragment);
        $this->assertStringContainsString(' :marks=\'{"0":"不爽","50":"有点爽","100":"很爽","150":"超爽"}\'', $fragment);
    }
}
