<?php

namespace Modules\CrudGenerate\Tests\Feature;

use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Modules\CrudGenerate\Services\CrudGenerateService;
use Modules\CrudGenerate\Services\FieldControlService;

class CrudGenerateTest extends AbstractAuthTestCase
{
    public function test_add_history()
    {
        $data = [
            'table_name'       => 'tests',
            'table_comment'    => '测试 Crud 生成',
            'soft_delete'      => 'yes',
            'primary_key'      => 'id',
            'parent_menu_code' => 'system.dev',
            'menu_name'        => '测试 Crud 生成',
            'menu_icon'        => 'fa fa-file-code-o',
            'gen_mode'         => 'module',
            'module_name'      => 'CrudGenerate',
            'gen_class_name'   => 'TestCrudGen',
            'column_list'      => [
                [
                    'field_name'                   => 'id',
                    'comment'                      => '主键',
                    'default_value'                => null,
                    'field_control'                => 'Dict',
                    'field_control_special_params' => [
                        'precision' => '0',
                        'allowed'   => ['1', '2'],
                        'length'    => 100,
                        'dict_code' => 'storage_mode',
                    ],
                    'page_view_control'                => null,
                    'page_view_control_special_params' => [],
                    'nullable'                         => 'no',
                    'gen_form'                         => 'yes',
                    'gen_index'                        => 'yes',
                    'gen_query'                        => 'no',
                    'gen_sort'                         => 'no',
                ],
            ],
        ];
        $response = $this->postJson('web/crud-generate/CrudGenerate/create', $data);
        $response->assertJson(['code' => 0]);

        $history = SystemCrudHistory::find($response->json('data.id'));

        // $fieldControlService = $this->app->make(FieldControlService::class);
        // $fieldFragment = $fieldControlService->analysisFieldContent($history);
        // \dd($fieldFragment);

        // $crudGenerateService = $this->app->make(CrudGenerateService::class);
        // $migrationContent = $crudGenerateService->getMigrationContent($history);
        // \dd($migrationContent);
    }
}
