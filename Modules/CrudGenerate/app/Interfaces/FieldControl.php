<?php

namespace Modules\CrudGenerate\Interfaces;

use Modules\CrudGenerate\Models\SystemCrudHistory;

interface FieldControl
{
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
     * 迁移代码字段片段
     *
     * @param array             $filed       字段信息
     * @param array             $allFields   所有字段信息
     * @param SystemCrudHistory $crudHistory crud历史信息
     */
    public function getMigrateCodeFragment($filed, $allFields, $crudHistory): string;
}
