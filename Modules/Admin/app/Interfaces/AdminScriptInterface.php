<?php

namespace Modules\Admin\Interfaces;

use Nwidart\Modules\Module;

interface AdminScriptInterface
{
    /**
     * 启用模块
     * @param Module $module 
     * @return mixed 
     */
    public function enable(Module $module);

    /**
     * 禁用模块
     * @param Module $module 
     * @return mixed 
     */
    public function disable(Module $module);
     
    /**
     * 删除模块
     * @param Module $module 
     * @return mixed 
     */
    public function delete(Module $module);
}
