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
                    'field_name'                       => 'id',
                    'comment'                          => '主键',
                    'default_value'                    => null,
                    'field_control'                    => 'Uuid',
                    'field_control_special_params'     => [],
                    'page_view_control'                => null,
                    'page_view_control_special_params' => [],
                    'page_view_control_query_params'   => [],
                    'nullable'                         => 'no',
                    'gen_form'                         => 'yes',
                    'gen_index'                        => 'yes',
                    'gen_query'                        => 'no',
                    'gen_sort'                         => 'no',
                ],
                [
                    'field_name'                       => 'name',
                    'comment'                          => '姓名',
                    'default_value'                    => null,
                    'field_control'                    => 'String',
                    'field_control_special_params'     => [],
                    'page_view_control'                => 'Input',
                    'page_view_control_special_params' => [],
                    'page_view_control_query_params'   => [
                        'query_like' => 'yes',
                    ],
                    'nullable'  => 'no',
                    'gen_form'  => 'yes',
                    'gen_index' => 'yes',
                    'gen_query' => 'yes',
                    'gen_sort'  => 'no',
                ],
                [
                    'field_name'                       => 'arr',
                    'comment'                          => '数组',
                    'default_value'                    => null,
                    'field_control'                    => 'String',
                    'field_control_special_params'     => [],
                    'page_view_control'                => 'CheckBox',
                    'page_view_control_special_params' => [
                        'kv' => [
                            ['选项1', 'a'],
                            ['选项2', 'b'],
                            ['选项3', 'c'],
                        ],
                    ],
                    'page_view_control_query_params' => [
                        'query_like' => 'yes',
                    ],
                    'nullable'  => 'no',
                    'gen_form'  => 'yes',
                    'gen_index' => 'yes',
                    'gen_query' => 'yes',
                    'gen_sort'  => 'no',
                ],
                [
                    'field_name'                       => 'num',
                    'comment'                          => '数字',
                    'default_value'                    => null,
                    'field_control'                    => 'Integer',
                    'field_control_special_params'     => [],
                    'page_view_control'                => 'InputNumber',
                    'page_view_control_special_params' => [
                        'range' => [1, 100],
                    ],
                    'page_view_control_query_params' => [
                        'query_like' => 'yes',
                    ],
                    'nullable'  => 'no',
                    'gen_form'  => 'yes',
                    'gen_index' => 'yes',
                    'gen_query' => 'yes',
                    'gen_sort'  => 'no',
                ],
            ],
        ];
        $response = $this->postJson('web/crud-generate/CrudGenerate/create', $data);
        $response->assertJson(['code' => 0]);

        $history = SystemCrudHistory::find($response->json('data.id'));

        // $fieldControlService = $this->app->make(FieldControlService::class);
        // $fieldFragment = $fieldControlService->analysisFieldContent($history);
        // \dd($fieldFragment);
        // $casts = $fieldControlService->analysisCasts($history);
        // \dd($casts);
        // $fillable = $fieldControlService->analysisFillable($history);
        // \dd($fillable);
        // $use_traits = $fieldControlService->analysisUseTraits($history);
        // \dd($use_traits);

        $crudGenerateService = $this->app->make(CrudGenerateService::class);
        // $migrationContent = $crudGenerateService->getMigrationContent($history);
        // \dd($migrationContent);
        // dd($history->toArray());
        // $modelContent = $crudGenerateService->getModelContent($history);
        // \dd($modelContent);
        // $requestContent = $crudGenerateService->getRequestContent($history);
        // \dd($requestContent);
        // $controllerContent = $crudGenerateService->getControllerContent($history);
        // \dd($controllerContent);
        // $viewIndexContent = $crudGenerateService->getViewIndexContent($history);
        // \dd($viewIndexContent);
        // $viewSaveContent = $crudGenerateService->getViewSaveContent($history);
        // \dd($viewSaveContent);
    }
}
