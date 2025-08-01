<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Contracts\Container\BindingResolutionException;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Models\SystemMenu as ModelsSystemMenu;

/**
 * 系统菜单服务
 * 请从容器中获取实例
 */
class SystemMenuRegisterService
{
    public static function getInstance()
    {
        return app(self::class);
    }

    public function getSystemMenuTree()
    {
        $menus = $this->getSystemMenuList();
        $tree  = ArrUtil::convertToTree($menus, 'parent_code', 'code', 'children');

        return $tree;
    }

    public function getSystemMenuList()
    {
        $menus = ModelsSystemMenu::all()->keyBy('code')->toArray();

        return $menus;
    }

    /**
     * 根据编码获取菜单
     *
     * @param  mixed $value
     * @param  mixed $key
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public function getBy($value, $key)
    {
        $list = $this->getSystemMenuList();
        foreach ($list as $item) {
            if ($item[$key] == $value) {
                return $item;
            }
        }

        return null;
    }
}
