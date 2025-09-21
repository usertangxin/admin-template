<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlTextarea;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageViewControlTextareaTest extends TestCase
{
    #[DataProvider('formCodeFragmentProvider')]
    public function test_get_form_code_fragment(array $params, array $expectedStrings)
    {
        $class = $this->app->make(PageViewControlTextarea::class);
        $class->make([
            'field_name'                       => 'content',
            'comment'                          => '内容',
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
            'textarea basic' => [
                [],
                ['a-textarea', 'v-model="formData.content"'],
            ],
            'textarea with auto size true' => [
                ['auto_size' => true],
                [':auto-size="true"'],
            ],
            'textarea with auto size custom' => [
                ['auto_size' => 'custom', 'rows' => [2, 6]],
                [':auto-size="{ minRows: 2, maxRows: 6 }"'],
            ],
            'textarea with max length' => [
                ['max_length' => 200],
                [':maxlength="200"'],
            ],
            'textarea with word limit show' => [
                ['show_word_limit' => 'yes'],
                [':show-word-limit="true"'],
            ],
            'textarea with allow clear' => [
                ['allow_clear' => 'yes'],
                [':allow-clear="true"'],
            ],
            'textarea with all attributes' => [
                [
                    'auto_size' => 'custom',
                    'rows' => [3, 10],
                    'max_length' => 500,
                    'show_word_limit' => 'yes',
                    'allow_clear' => 'yes'
                ],
                [
                    ':auto-size="{ minRows: 3, maxRows: 10 }"',
                    ':maxlength="500"',
                    ':show-word-limit="true"',
                    ':allow-clear="true"'
                ],
            ],
            'textarea with auto size false' => [
                ['auto_size' => false],
                ['a-textarea', 'v-model="formData.content"'],
            ],
            'textarea with custom rows single value' => [
                ['auto_size' => 'custom', 'rows' => [4, 4]],
                [':auto-size="{ minRows: 4, maxRows: 4 }"'],
            ],
        ];
    }
}
