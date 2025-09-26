<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\FieldControlRemoteSelect;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageViewControlRemoteSelectTest extends TestCase
{
    #[DataProvider('formCodeFragmentProvider')]
    public function test_get_form_code_fragment(array $params, array $expectedStrings)
    {
        $class = $this->app->make(FieldControlRemoteSelect::class);
        $class->make([
            'field_name'                       => 'remote_select',
            'comment'                          => '远程选择',
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
            'remote select basic' => [
                [],
                [
                    'remote-select',
                    'v-model="formData.remote_select"',
                    'placeholder="请搜索选择远程选择"',
                    'url=""',
                    'label-field="name"',
                    'value-field="id"',
                    'data-field="data"',
                ],
            ],
            'remote select with custom url' => [
                ['url' => '/api/users'],
                ['url="/api/users"'],
            ],
            'remote select with custom fields' => [
                [
                    'label-field' => 'title',
                    'value-field' => 'uid',
                    'data-field'  => 'items',
                ],
                [
                    'label-field="title"',
                    'value-field="uid"',
                    'data-field="items"',
                ],
            ],
            'remote select with allow clear' => [
                ['allow-clear' => 'yes'],
                [' allow-clear'],
            ],
            'remote select with multiple' => [
                ['multiple' => 'yes'],
                [' multiple'],
            ],
            'remote select with allow search' => [
                ['allow-search' => 'yes'],
                [' allow-search'],
            ],
            'remote select with all attributes' => [
                [
                    'url'          => '/api/categories',
                    'label-field'  => 'name',
                    'value-field'  => 'code',
                    'data-field'   => 'list',
                    'allow-clear'  => 'yes',
                    'multiple'     => 'yes',
                    'allow-search' => 'yes',
                ],
                [
                    'url="/api/categories"',
                    'label-field="name"',
                    'value-field="code"',
                    'data-field="list"',
                    ' allow-clear',
                    ' multiple',
                    ' allow-search',
                ],
            ],
            'remote select with complex url' => [
                ['url' => '/api/resources?type=product&status=active'],
                ['url="/api/resources?type=product&status=active"'],
            ],
            'remote select with no allow clear' => [
                ['allow-clear' => 'no'],
                ['remote-select', 'v-model="formData.remote_select"'], // 不包含 ' allow-clear'
            ],
            'remote select with no multiple' => [
                ['multiple' => 'no'],
                ['remote-select', 'v-model="formData.remote_select"'], // 不包含 ' multiple'
            ],
        ];
    }
}
