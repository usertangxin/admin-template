<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Models\SystemMenu as ModelsSystemMenu;

/**
 * 系统菜单服务
 * 请从容器中获取实例
 */
class SystemMenuService
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

    public function getMyPermissionTree()
    {
        // TODO: 实现获取用户权限树的方法
    }

    public function getSystemMenuList()
    {
        $query = ModelsSystemMenu::query();
        // if (Auth::check() && ! Auth::user()->is_root) {
        //     $query->whereIn('code', Auth::user()->getPermissionNames()->toArray())
        //         ->orWhereIn('type', [SystemMenuType::GROUP])
        //         ->orWhere('allow_admin', '=', true)
        //         ->orWhere('allow_all', '=', true);
        // }
        $this->menus ??= $query->get()->keyBy('code')->toArray();

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
