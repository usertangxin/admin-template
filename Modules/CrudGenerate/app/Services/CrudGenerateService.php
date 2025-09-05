<?php

namespace Modules\CrudGenerate\Services;

use Modules\CrudGenerate\Models\SystemCrudHistory;
use Nwidart\Modules\Support\Stub;

class CrudGenerateService
{
    public function getStubsBasePath()
    {
        if (\is_dir(\base_path('stubs/crud-generate'))) {
            return \base_path('stubs/crud-generate');
        }

        return \module_path('CrudGenerate', 'stubs');
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
}
