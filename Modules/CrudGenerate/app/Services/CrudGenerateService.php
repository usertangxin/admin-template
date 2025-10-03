<?php

namespace Modules\CrudGenerate\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\PathNamespace;

class CrudGenerateService
{
    use PathNamespace;

    public function getStubsBasePath()
    {
        if (\is_dir(\base_path('stubs/crud-generate'))) {
            return \base_path('stubs/crud-generate');
        }

        return \module_path('CrudGenerate', 'stubs');
    }

    public function getDefaultNamespace($type): string
    {
        return config("modules.paths.generator.{$type}.namespace")
            ?? ltrim(config("modules.paths.generator.{$type}.path", 'Classes'), config('modules.paths.app_folder', ''));
    }

    /**
     * Get class namespace.
     *
     * @param  \Nwidart\Modules\Module $module
     * @return string
     */
    public function getClassNamespace($module, $class_name, $type)
    {
        $path_namespace = $this->path_namespace(str_replace(class_basename($class_name), '', $class_name));

        return $this->module_namespace($module->getStudlyName(), $this->getDefaultNamespace($type) . ($path_namespace ? '\\' . $path_namespace : ''));
    }

    public function gen() {}

    /**
     * 分析迁移文件内容
     * @param SystemCrudHistory $crudHistory 
     * @return string 
     * @throws BindingResolutionException 
     */
    public function getMigrationContent(SystemCrudHistory $crudHistory)
    {
        $fieldControlService = \app(FieldControlService::class);
        $fieldFragment       = $fieldControlService->analysisFieldContent($crudHistory);
        // 对 $fieldFragment 进行处理，除首行外每行前添加缩进
        $lines         = explode("\n", $fieldFragment);
        $indentedLines = array_map(function ($index, $line) {
            if ($index > 0) {
                return '            ' . $line;
            }

            return $line;
        }, array_keys($lines), $lines);
        $fieldFragment = implode("\n", $indentedLines);
        $stub          = new Stub('/migration/create.stub', [
            'TABLE'  => $crudHistory->table_name,
            'FIELDS' => $fieldFragment,
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    /**
     * 分析模型文件内容
     * @param SystemCrudHistory $crudHistory 
     * @return string 
     * @throws BindingResolutionException 
     * @throws InvalidArgumentException 
     */
    public function getModelContent(SystemCrudHistory $crudHistory)
    {
        $fieldControlService    = \app(FieldControlService::class);
        $pageViewControlService = \app(PageViewControlService::class);

        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $use_traits = $fieldControlService->analysisUseTraits($crudHistory);

        $namespace = $crudHistory->gen_mode === 'module' ? $this->getClassNamespace(module($module_name, true), $class_name, 'model') : 'App\Models';

        $fillable           = $fieldControlService->analysisFillable($crudHistory);
        $casts              = $pageViewControlService->analysisCasts($crudHistory);
        $queryScopeFragment = $pageViewControlService->analysisQueryScopeFragment($crudHistory);

        $stub = new Stub('/model.stub', [
            'NAMESPACE'    => $namespace,
            'CLASS'        => class_basename($class_name),
            'PARENT_MODEL' => $crudHistory->soft_delete == 'yes' ? 'AbstractSoftDelModel' : 'AbstractModel',
            'TRAITS'       => $use_traits,
            'TABLE'        => $crudHistory->table_name,
            'FILLABLE'     => $fillable,
            'CASTS'        => $casts,
            'SCOPES'       => $queryScopeFragment,
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    /**
     * 分析请求验证文件内容
     * @param SystemCrudHistory $crudHistory 
     * @return string 
     * @throws BindingResolutionException 
     * @throws InvalidArgumentException 
     */
    public function getRequestContent(SystemCrudHistory $crudHistory)
    {
        $pageViewControlService = \app(PageViewControlService::class);

        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $namespace = $crudHistory->gen_mode === 'module' ? $this->getClassNamespace(module($module_name, true), $class_name, 'request') : 'App\Http\Requests';

        $stub = new Stub('/request.stub', [
            'NAMESPACE' => $namespace,
            'CLASS'     => class_basename($class_name) . 'Request',
            'RULES'     => $pageViewControlService->analysisRequestRules($crudHistory),
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    /**
     * 分析控制器文件内容
     * @param SystemCrudHistory $crudHistory 
     * @return string 
     * @throws BindingResolutionException 
     * @throws InvalidArgumentException 
     */
    public function getControllerContent(SystemCrudHistory $crudHistory)
    {
        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $namespace = $crudHistory->gen_mode === 'module' ? $this->getClassNamespace(module($module_name, true), $class_name, 'controller') : 'App\Http\Controllers';

        $model_namespace = $crudHistory->gen_mode === 'module' ? $this->getClassNamespace(module($module_name, true), $class_name, 'model') : 'App\Models';

        $stub = new Stub('/controller.stub', [
            'CLASS_NAMESPACE' => $namespace,
            'MODEL_NAMESPACE' => $model_namespace . '\\' . class_basename($class_name),
            'CLASS'     => class_basename($class_name) . 'Controller',
            'MODEL' => class_basename($class_name),
            'MENU_NAME' => $crudHistory->menu_name,
            'PARENT_CODE' => $crudHistory->parent_menu_code ? "'{$crudHistory->parent_menu_code}'" : 'null',
            'ICON' => $crudHistory->menu_icon,
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    /**
     * 分析索引视图文件内容
     * @param SystemCrudHistory $crudHistory 
     * @return string 
     * @throws BindingResolutionException 
     */
    public function getViewIndexContent(SystemCrudHistory $crudHistory)
    {
        $pageViewControlService = \app(PageViewControlService::class);

        // $class_name = $crudHistory->gen_class_name;

        $stub = new Stub('/views/pages/index.stub', [
            'SEARCH_HTML' => $pageViewControlService->analysisIndexSearchHtmlFragment($crudHistory),
            'COLUMNS_JS' => $pageViewControlService->analysisIndexColumnFragment($crudHistory),
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    public function getViewSaveContent(SystemCrudHistory $crudHistory)
    {
        $pageViewControlService = \app(PageViewControlService::class);

        // $class_name = $crudHistory->gen_class_name;

        $stub = new Stub('/views/pages/save.stub', [
            'FORM_HTML' => $pageViewControlService->analysisFormCodeFragment($crudHistory),
            'FORM_DATA_JS' => $pageViewControlService->analysisFormDataJsFragment($crudHistory),
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }
}
