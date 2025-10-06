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
     * 获取扩展数据作用域视图
     *
     * @return mixed
     */
    public function getExtendDataScopeViewCodeFragment();

    /**
     * 同步全局作用域数据
     *
     * @param $data
     * @return mixed
     */
    public function handleSyncExtendDataScope($data);
}
