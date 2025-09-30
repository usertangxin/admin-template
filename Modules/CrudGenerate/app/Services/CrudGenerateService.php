<?php

namespace Modules\CrudGenerate\Services;

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

    public function getRequestContent(SystemCrudHistory $crudHistory)
    {
        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $namespace = $crudHistory->gen_mode === 'module' ? $this->getClassNamespace(module($module_name, true), $class_name, 'request') : 'App\Http\Requests';

        $stub = new Stub('/request.stub', [
            'NAMESPACE' => $namespace,
            'CLASS'     => class_basename($class_name) . 'Request',
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }
}
