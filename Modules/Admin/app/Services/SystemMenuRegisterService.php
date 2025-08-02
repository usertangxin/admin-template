<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Models\SystemMenu as ModelsSystemMenu;

/**
 * 系统菜单服务
 * 请从容器中获取实例
 */
class SystemMenuRegisterService
{
    protected ?array $menus = null;

    protected ?array $tree = null;

    public static function getInstance()
    {
        return app(self::class);
    }

    public function getSystemMenuTree()
    {
        $this->tree ??= ArrUtil::convertToTree($this->getSystemMenuList(), 'parent_code', 'code', 'children');

        return $this->tree;
    }

    public function getSystemMenuList()
    {
        $this->menus ??= ModelsSystemMenu::all()->keyBy('code')->toArray();

        return $this->menus;
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

    public function refresh()
    {
        $this->menus = null;
        $this->tree  = null;
    }
}
