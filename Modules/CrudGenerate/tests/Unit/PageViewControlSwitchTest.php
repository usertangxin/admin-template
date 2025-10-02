<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlSwitch;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageViewControlSwitchTest extends TestCase
{
    #[DataProvider('formCodeFragmentProvider')]
    public function test_get_form_code_fragment(array $params, array $expectedStrings)
    {
        $class = $this->app->make(PageViewControlSwitch::class);
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
            'switch basic circle' => [
                ['type' => 'circle'],
                ['type="circle"'],
            ],
            'switch round type' => [
                ['type' => 'round'],
                ['type="round"'],
            ],
            'switch line type' => [
                ['type' => 'line'],
                ['type="line"'],
            ],
            'switch with checked value' => [
                ['checked-value' => '1'],
                [':checked-value=\'1\''],
            ],
            'switch with unchecked value' => [
                ['unchecked-value' => '0'],
                [':unchecked-value=\'0\''],
            ],
            'switch with checked text' => [
                ['checked-text' => '是'],
                ['checked-text="是"'],
            ],
            'switch with unchecked text' => [
                ['unchecked-text' => '否'],
                ['unchecked-text="否"'],
            ],
            'switch with all attributes' => [
                [
                    'type'            => 'round',
                    'checked-value'   => 'true',
                    'unchecked-value' => 'false',
                    'checked-text'    => '启用',
                    'unchecked-text'  => '禁用',
                ],
                [
                    'type="round"',
                    ':checked-value=\'true\'',
                    ':unchecked-value=\'false\'',
                    'checked-text="启用"',
                    'unchecked-text="禁用"',
                ],
            ],
            'switch with string checked value' => [
                ['checked-value' => '\'active\''],
                [':checked-value=\'"active"\''],
            ],
            'switch with string unchecked value' => [
                ['unchecked-value' => '\'inactive\''],
                [':unchecked-value=\'"inactive"\''],
            ],
        ];
    }
}
