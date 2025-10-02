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
     * 特有查询参数
     */
    public function getQueryParams(): array|string;

    /**
     * 视图代码片段
     */
    public function getFormCodeFragment(): string;

    /**
     * 列表页列代码片段
     */
    public function getIndexColumnFragment(): array;

    /**
     * 列表页查询代码片段
     */
    public function getIndexQueryHtmlFragment(): string;

    /**
     * 查询查询范围代码片段
     */
    public function getQueryScopeFragment(): string;

    /**
     * 数据库字段类型转换
     */
    public function getModelCast(): ?string;

    /**
     * 请求验证规则
     */
    public function getRequestRules(): null|array|string;
}
