<?php

namespace Modules\Admin\Interfaces;

use Illuminate\Database\Eloquent\Scope;

interface GlobalDataPermissionScopeInterface extends Scope
{
    /**
     * 作用于名称，唯一
     *
     * @return mixed
     */
    public function getScopeName();

    /**
     * 获取扩展数据作用域视图，需要将组件注册为全局组件
     * 双向绑定传递 extend_data_scope
     *
     * @return mixed
     */
    public function getExtendDataScopeViewName();

    /**
     * 同步全局作用域数据
     *
     * @return mixed
     */
    public function handleSyncExtendDataScope($data);
}
