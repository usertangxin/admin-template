<?php

namespace Modules\CrudGenerate\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\Admin\Services\ResponseService;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use Nwidart\Modules\Module;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\PathNamespace;

class CrudGenerateService
{
    use PathNamespace;

    public function getStubsBasePath()
    {
        if (is_dir(base_path('stubs/crud-generate'))) {
            $path = base_path('stubs/crud-generate');
        } else {
            $path = module_path('CrudGenerate', 'stubs');
        }

        return str_replace('\\', '/', $path);
    }

    protected function getDefaultNamespace($type): string
    {
        return config("modules.paths.generator.$type.namespace")
            ?? ltrim(config("modules.paths.generator.$type.path", 'Classes'), config('modules.paths.app_folder', ''));
    }

    /**
     * Get class namespace.
     *
     * @return string
     */
    protected function getClassNamespace(Module $module, $class_name, $type, SystemCrudHistory $crudHistory)
    {
        if ($crudHistory->gen_mode == 'module') {
            $path_namespace = $this->path_namespace(Str::replaceLast(class_basename($class_name), '', $class_name));

            return $this->module_namespace($module->getStudlyName(), $this->getDefaultNamespace($type) . ($path_namespace ? '\\' . $path_namespace : ''));
        }

        $map = [
            'model'      => 'App\Models',
            'request'    => 'App\Http\Requests',
            'controller' => 'App\Http\Controllers',
        ];

        $a = Str::replaceLast('/' . class_basename($class_name), '', $class_name);
        if ($a == $class_name) {
            return $map[$type];
        }

        $a = Str::replace('/', '\\', $a);

        return $map[$type] . '\\' . $a;

    }

    protected function getDestinationFilePath(Module $module, $type, $file_name, SystemCrudHistory $crudHistory)
    {
        if ($crudHistory->gen_mode == 'module') {
            return $this->getDestinationFilePathModule($module, $type, $file_name);
        }

        $map = [
            'migration'  => 'database/migrations/',
            'model'      => 'app/Models/',
            'request'    => 'app/Http/Requests/',
            'controller' => 'app/Http/Controllers/',
            'assets'     => 'resources/',
        ];

        return $map[$type] . $file_name;

    }

    protected function getDestinationFilePathModule(Module $module, $type, $file_name)
    {
        $path = module_path($module->getStudlyName());

        $path = str_replace(base_path(DIRECTORY_SEPARATOR), '', $path);

        $generatorPath = GenerateConfigReader::read($type);

        $path = $path . '/' . $generatorPath->getPath() . '/' . $file_name;
        $path = str_replace('//', '/', $path);

        return str_replace('\\', '/', $path);
    }

    public function gen(SystemCrudHistory $crudHistory)
    {
        $fileContentMap = $this->fileContentMap($crudHistory);

        $oldFileList = $crudHistory->file_list;
        if ($oldFileList) {
            foreach ($oldFileList as $file_path) {
                $real_path = base_path($file_path);
                if (file_exists($real_path)) {
                    unlink($real_path);
                }
            }
        }

        $fileList = [];
        foreach ($fileContentMap as $value) {
            $file_path = $value['path'];
            $real_path = base_path($file_path);
            $content   = $value['content'];
            File::ensureDirectoryExists(dirname($real_path));
            File::put($real_path, $content);
            $fileList[] = $file_path;
        }

        $crudHistory->file_list = $fileList;
        $crudHistory->save();
    }

    public function fileContentMap(SystemCrudHistory $crudHistory)
    {
        $class_name  = $crudHistory->gen_class_name;
        $base_name   = class_basename($class_name);
        $module_name = $crudHistory->module_name;

        $controllerClass = $this->getClassNamespace(module($module_name, true), $class_name, 'controller', $crudHistory) . '\\' . class_basename($class_name) . 'Controller';

        $viewTierPath = ResponseService::getViewTierPath($controllerClass);

        $migration_filename = date('Y_m_d_His_') . 'create_' . $crudHistory->table_name . '_table.php';

        return [
            'migration' => [
                'file_name' => $migration_filename,
                'path'      => $this->getDestinationFilePath(module($module_name, true), 'migration', $migration_filename, $crudHistory),
                'content'   => $this->getMigrationContent($crudHistory),
                'lang'      => 'php',
            ],
            'model' => [
                'file_name' => $base_name . '.php',
                'path'      => $this->getDestinationFilePath(module($module_name, true), 'model', $class_name . '.php', $crudHistory),
                'content'   => $this->getModelContent($crudHistory),
                'lang'      => 'php',
            ],
            'request' => [
                'file_name' => $base_name . 'Request.php',
                'path'      => $this->getDestinationFilePath(module($module_name, true), 'request', $class_name . 'Request.php', $crudHistory),
                'content'   => $this->getRequestContent($crudHistory),
                'lang'      => 'php',
            ],
            'controller' => [
                'file_name' => $base_name . 'Controller.php',
                'path'      => $this->getDestinationFilePath(module($module_name, true), 'controller', $class_name . 'Controller.php', $crudHistory),
                'content'   => $this->getControllerContent($crudHistory),
                'lang'      => 'php',
            ],
            'index.vue' => [
                'file_name' => 'index.vue',
                'path'      => $this->getDestinationFilePath(module($module_name, true), 'assets', 'js/pages/' . $viewTierPath . '/index.vue', $crudHistory),
                'content'   => $this->getViewIndexContent($crudHistory),
                'lang'      => 'vue',
            ],
            'save.vue' => [
                'file_name' => 'save.vue',
                'path'      => $this->getDestinationFilePath(module($module_name, true), 'assets', 'js/pages/' . $viewTierPath . '/save.vue', $crudHistory),
                'content'   => $this->getViewSaveContent($crudHistory),
                'lang'      => 'vue',
            ],
        ];
    }

    /**
     * 分析迁移文件内容
     *
     * @return string
     */
    public function getMigrationContent(SystemCrudHistory $crudHistory)
    {
        $fieldControlService = app(FieldControlService::class);
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
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getModelContent(SystemCrudHistory $crudHistory)
    {
        $fieldControlService    = app(FieldControlService::class);
        $pageViewControlService = app(PageViewControlService::class);

        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $use_traits = $fieldControlService->analysisUseTraits($crudHistory);

        $namespace = $this->getClassNamespace(module($module_name, true), $class_name, 'model', $crudHistory);

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
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getRequestContent(SystemCrudHistory $crudHistory)
    {
        $fieldControlService    = app(FieldControlService::class);
        $pageViewControlService = app(PageViewControlService::class);

        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $namespace = $this->getClassNamespace(module($module_name, true), $class_name, 'request', $crudHistory);

        $stub = new Stub('/request.stub', [
            'NAMESPACE'  => $namespace,
            'CLASS'      => class_basename($class_name) . 'Request',
            'RULES'      => $pageViewControlService->analysisRequestRules($crudHistory),
            'ATTRIBUTES' => $fieldControlService->analysisRequestAttributes($crudHistory),
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    /**
     * 分析控制器文件内容
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getControllerContent(SystemCrudHistory $crudHistory)
    {
        $class_name = $crudHistory->gen_class_name;

        $module_name = $crudHistory->module_name;

        $namespace = $this->getClassNamespace(module($module_name, true), $class_name, 'controller', $crudHistory);

        $model_namespace = $this->getClassNamespace(module($module_name, true), $class_name, 'model', $crudHistory);

        $stub = new Stub('/controller.stub', [
            'CLASS_NAMESPACE' => $namespace,
            'MODEL_NAMESPACE' => $model_namespace . '\\' . class_basename($class_name),
            'CLASS'           => class_basename($class_name) . 'Controller',
            'MODEL'           => class_basename($class_name),
            'MENU_NAME'       => $crudHistory->menu_name,
            'PARENT_CODE'     => $crudHistory->parent_menu_code ? "'$crudHistory->parent_menu_code'" : 'null',
            'ICON'            => $crudHistory->menu_icon ? "'$crudHistory->menu_icon'" : 'null',
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    /**
     * 分析索引视图文件内容
     *
     * @return string
     */
    public function getViewIndexContent(SystemCrudHistory $crudHistory)
    {
        $pageViewControlService = app(PageViewControlService::class);

        // $class_name = $crudHistory->gen_class_name;

        $stub = new Stub('/views/pages/index.stub', [
            'SEARCH_HTML' => $pageViewControlService->analysisIndexSearchHtmlFragment($crudHistory),
            'COLUMNS_JS'  => $pageViewControlService->analysisIndexColumnFragment($crudHistory),
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }

    public function getViewSaveContent(SystemCrudHistory $crudHistory)
    {
        $pageViewControlService = app(PageViewControlService::class);

        // $class_name = $crudHistory->gen_class_name;

        $stub = new Stub('/views/pages/save.stub', [
            'FORM_HTML'    => $pageViewControlService->analysisFormCodeFragment($crudHistory),
            'FORM_DATA_JS' => $pageViewControlService->analysisFormDataJsFragment($crudHistory),
        ]);
        $stub->setBasePath($this->getStubsBasePath());

        return $stub->render();
    }
}
