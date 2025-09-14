<?php

namespace Modules\CrudGenerate\Interfaces;

use Modules\CrudGenerate\Models\SystemCrudHistory;

interface PageViewControl
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
     */
    public function getSpecialParams(): array|string;

    /**
     * 视图代码片段
     */
    public function getViewCodeFragment(): string;
}
