<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Modules\Admin\Models\SystemMenu as ModelsSystemMenu;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * 系统权限服务
 * 请从容器中获取实例
 */
class SystemPermissionService
{
    protected ?array $menus = null;

    protected ?array $tree = null;

    public static function getInstance()
    {
        return app(self::class);
    }

    /**
     * 获取系统菜单树
     *
     * @return array
     */
    public function getSystemMenuTree()
    {
        $this->tree ??= ArrUtil::convertToTree($this->getSystemMenuList(), 'parent_code', 'code', 'children');

        return $this->tree;
    }

    /**
     * 获取用户权限树
     *
     * @return array
     */
    public function getMyPermissionTree()
    {
        $list = \collect($this->getSystemMenuList());
        $list = $list->filter(function ($item) {
            if ($item['type'] == SystemMenuType::GROUP) {
                return true;
            }
            // 如果允许所有访问，则不需要展示
            if ($item['allow_all'] || $item['allow_admin']) {
                return false;
            }

            if ($item['is_hidden']) {
                return false;
            }

            if (FacadesAuth::user()->is_root) {
                return true;
            }

            if (in_array($item['code'], Auth::user()->getAllPermissions()->pluck('name')->toArray())) {
                return true;
            }

            return false;
        })->toArray();
        $list = ArrUtil::convertToTree($list, 'parent_code', 'code', 'children');

        $list = ArrUtil::recursiveFilter($list, function ($item) {
            if ($item['type'] == SystemMenuType::GROUP && (! isset($item['children']) || count($item['children']) == 0)) {
                return false;
            }

            return true;
        });

        return $list;
    }

    /**
     * 获取我的角色
     *
     * @return mixed
     *
     * @throws BadRequestException
     */
    public function getMyRoles()
    {
        $user = Auth::user();
        if ($user->is_root) {
            return \app(PermissionRegistrar::class)->getRoleClass()::all();
        }

        return Auth::user()->roles;
    }

    /**
     * 获取系统菜单列表
     *
     * @return array
     */
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

    /**
     * 刷新菜单缓存
     *
     * @return void
     */
    public function refresh()
    {
        $this->menus = null;
        $this->tree  = null;
    }
}
