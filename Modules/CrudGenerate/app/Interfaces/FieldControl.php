<?php

namespace Modules\CrudGenerate\Interfaces;

use Modules\CrudGenerate\Models\SystemCrudHistory;

interface FieldControl
{
    /**
     * 初始化
     */
    public function make(array $field, array $allFields, SystemCrudHistory $crudHistory);

    /**
     * 显示在 crud 页面上的名称
     */
    public function getLabel(): string;

    /**
     * 存储在数据库中的名称
     */
    public function getName(): string;

    /**
     * 特有参数
     *
     * @return array<SpecialParam>|string
     */
    public function getSpecialParams(): array|string;

    /**
     * 迁移文件代码片段
     * 
     * @return string 
     */
    public function getMigrateCodeFragment(): string;

    /**
     * 模型使用的 trait
     */
    public function getModelUseTraits(): array;
}
