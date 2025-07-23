<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Classes\Utils\SystemMenuType;

/**
 * 系统菜单服务
 * 请从容器中获取实例
 */
class SystemMenuRegisterService
{
    private $system_menus = [];

    public static function getInstance()
    {
        return app(self::class);
    }

    public function fastRoute($controller)
    {
        Route::controller($controller)->group(function () use ($controller) {
            $ref = new \ReflectionClass($controller);
            $methods = $ref->getMethods();
            $shortName = $ref->getShortName();
            $ignore_actions = [];
            $ignore_methods = [];
            if ($ref->hasConstant('IGNORE_ACTIONS')) {
                $ignore_actions = $ref->getConstant('IGNORE_ACTIONS');
            }
            if ($ref->hasConstant('IGNORE_METHODS')) {
                $ignore_methods = $ref->getConstant('IGNORE_METHODS');
            }
            $prefix = str_replace('Controller', '', $shortName);

            $ctlSystemMenuAttrs = $ref->getAttributes(SystemMenu::class);
            $ctlSystemMenuAttr = null;
            if ($ctlSystemMenuAttrs) {
                $ctlSystemMenuAttr = $ctlSystemMenuAttrs[0]->newInstance();
                $ctlSystemMenuAttr->type ??= SystemMenuType::GROUP;
                $ctlSystemMenuAttr->code ??= $ref->getName();
                if (isset($this->system_menus[$ctlSystemMenuAttr->code])) {
                    throw new \Exception('系统菜单编码重复:' . $ctlSystemMenuAttr->code);
                }
                // $this->system_menus[$ctlSystemMenuAttr->code] = (array) $ctlSystemMenuAttr;
            }

            $action_map = [];

            foreach ($methods as $method) {
                if ($method->isPublic() && ! $method->isConstructor()) {
                    $name = $method->getName();
                    if (in_array($name, $ignore_methods)) {
                        continue;
                    }
                    $actionName = $name;
                    $route_action = 'any';
                    $actions = ['get', 'post', 'put', 'delete', 'patch'];
                    foreach ($actions as $action) {
                        if (str_starts_with($actionName, $action)) {
                            $route_action = $action;
                            $actionName = str_replace($action . '', '', $actionName);
                            $actionName = Str::lcfirst($actionName);
                            break;
                        }
                    }
                    if (in_array($actionName, $ignore_actions)) {
                        continue;
                    }

                    $mtdSystemMenuAttr = $method->getAttributes(SystemMenu::class)[0]->newInstance();

                    $uri = $prefix . '/' . Str::kebab($actionName);
                    $routeName = $prefix . '.' . Str::kebab($actionName);
                    $fullUri = $this->prefix($uri);

                    /** @var \Illuminate\Routing\Route $route */
                    $route = Route::$route_action($uri, [$controller, $name])->name($routeName);

                    $mtdSystemMenuAttr->url = $fullUri;
                    $mtdSystemMenuAttr->type ??= SystemMenuType::ACTION;
                    $mtdSystemMenuAttr->code ??= $route->getName();
                    if ($method->getName() === 'index') {
                        $mtdSystemMenuAttr->parent_code ??= $ctlSystemMenuAttr?->code;
                        $mtdSystemMenuAttr->type = SystemMenuType::MENU;
                        if ($ctlSystemMenuAttr) {
                            $mtdSystemMenuAttr->name = $ctlSystemMenuAttr->name;
                            $mtdSystemMenuAttr->icon = $ctlSystemMenuAttr->icon;
                            $mtdSystemMenuAttr->parent_code = $ctlSystemMenuAttr->parent_code;
                        }
                    } else {
                        $mtdSystemMenuAttr->parent_code ??= preg_replace('/' . '.' . Str::kebab($actionName) . '(?=.*$)/', '', $route->getName(), 1) . '.index';
                    }
                    // if(isset($this->system_menus[$mtdSystemMenuAttr->code])) {
                    //     throw new \Exception('系统菜单编码重复:' . $mtdSystemMenuAttr->code);
                    // }
                    $this->pushSystemMenu($mtdSystemMenuAttr);
                }
            }
        });
    }

    public function pushSystemMenu(SystemMenu $systemMenu)
    {
        $menu = (array) $systemMenu;
        unset($menu['children']);
        $this->system_menus[$systemMenu->code] = $menu;
    }

    public function getOriginSystemMenu()
    {
        return $this->system_menus;
    }

    public function getSystemMenuTree()
    {
        $cache_file_path = \config('cache.stores.file.path') . '/system_menus_tree.php';
        $tree = null;
        if (! file_exists($cache_file_path)) {
            if (! $this->system_menus) {
                // 如果是空值那么猜测是缓存了路由
                // 这个时候就尝试刷新路由获取菜单树并缓存
                $route_cache_file = app()->getCachedRoutesPath();
                if (\file_exists($route_cache_file)) {
                    Artisan::call('route:cache');
                    $tree = ArrUtil::convertToTree($this->system_menus, 'parent_code', 'code', 'children');
                    if ($tree) {
                        $this->writeMenuTreeToCacheFile($tree);
                    }
                }
            }
            $tree ??= ArrUtil::convertToTree($this->system_menus, 'parent_code', 'code', 'children');

            return $tree;
        }
        $tree = include_once $cache_file_path;

        return $tree;
    }

    public function getSystemMenuList()
    {
        $cache_file_path = \config('cache.stores.file.path') . '/system_menus.php';
        $menus = null;
        if (! file_exists($cache_file_path)) {
            if (! $this->system_menus) {
                // 如果是空值那么猜测是缓存了路由
                // 这个时候就尝试刷新路由获取菜单树并缓存
                $route_cache_file = app()->getCachedRoutesPath();
                if (\file_exists($route_cache_file)) {
                    Artisan::call('route:cache');
                    $this->writeMenuToCacheFile($this->system_menus);
                }
            }

            return $this->system_menus;
        }
        $menus = include_once $cache_file_path;

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

    public function writeMenuTreeToCacheFile($tree)
    {
        $cache_file_path = \config('cache.stores.file.path') . '/system_menus_tree.php';
        $treeCode = \var_export($tree, true);
        $file_content = <<<EOF
<?php

return $treeCode;
EOF;
        file_put_contents($cache_file_path, $file_content);
    }

    public function writeMenuToCacheFile($menus)
    {
        $cache_file_path = \config('cache.stores.file.path') . '/system_menus.php';
        $menusCode = \var_export($menus, true);
        $file_content = <<<EOF
<?php

return $menusCode;
EOF;
        file_put_contents($cache_file_path, $file_content);
    }

    public function deleteCacheFile()
    {
        $cache_tree_file_path = \config('cache.stores.file.path') . '/system_menus_tree.php';
        if (file_exists($cache_tree_file_path)) {
            unlink($cache_tree_file_path);
        }
        $cache_file_path = \config('cache.stores.file.path') . '/system_menus.php';
        if (file_exists($cache_file_path)) {
            unlink($cache_file_path);
        }
    }

    private function prefix($uri)
    {
        return trim(trim(Route::getLastGroupPrefix(), '/') . '/' . trim($uri, '/'), '/') ?: '/';
    }
}
