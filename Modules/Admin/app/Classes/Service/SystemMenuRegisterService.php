<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\ArrUtil;
use Modules\Admin\Classes\Utils\SystemMenuType;

class SystemMenuRegisterService
{
    private static $system_menus = [];

    private function __construct() {}

    public static function fastRoute($controller)
    {
        Route::controller($controller)->group(function () use ($controller) {
            $ref = new \ReflectionClass($controller);
            $methods = $ref->getMethods();
            $shortName = $ref->getShortName();
            $prefix = str_replace('Controller', '', $shortName);

            $ctlSystemMenuAttrs = $ref->getAttributes(SystemMenu::class);
            $ctlSystemMenuAttr = null;
            if ($ctlSystemMenuAttrs) {
                $ctlSystemMenuAttr = $ctlSystemMenuAttrs[0]->newInstance();
                $ctlSystemMenuAttr->type ??= SystemMenuType::GROUP;
                $ctlSystemMenuAttr->code ??= $ref->getName();
                if (isset(static::$system_menus[$ctlSystemMenuAttr->code])) {
                    throw new \Exception('系统菜单编码重复:'.$ctlSystemMenuAttr->code);
                }
                static::$system_menus[$ctlSystemMenuAttr->code] = (array) $ctlSystemMenuAttr;
            }

            foreach ($methods as $method) {
                if ($method->isPublic() && ! $method->isConstructor()) {
                    $name = $method->getName();
                    $actionName = $name;

                    $mtdSystemMenuAttr = $method->getAttributes(SystemMenu::class)[0]->newInstance();

                    $route_action = 'any';
                    $actions = ['get', 'post', 'put', 'delete', 'patch'];
                    foreach ($actions as $action) {
                        if (str_starts_with($actionName, $action)) {
                            $route_action = $action;
                            $actionName = str_replace($action.'', '', $actionName);
                            $actionName = Str::lcfirst($actionName);
                            break;
                        }
                    }

                    $uri = $prefix.'/'.$actionName;
                    $routeName = $prefix.'.'.$actionName;
                    $fullUri = static::prefix($uri);

                    $mtdSystemMenuAttr->url = $fullUri;
                    $mtdSystemMenuAttr->type ??= SystemMenuType::ACTION;
                    $mtdSystemMenuAttr->code ??= $ref->getName().'.'.$method->getName();
                    if ($method->getName() === 'index') {
                        $mtdSystemMenuAttr->parent_code ??= $ctlSystemMenuAttr?->code;
                    } else {
                        $mtdSystemMenuAttr->parent_code ??= $ref->getName().'.index';
                    }
                    // if(isset(static::$system_menus[$mtdSystemMenuAttr->code])) {
                    //     throw new \Exception('系统菜单编码重复:' . $mtdSystemMenuAttr->code);
                    // }
                    static::$system_menus[$mtdSystemMenuAttr->code] = (array) $mtdSystemMenuAttr;

                    Route::$route_action($uri, [$controller, $name])->name($routeName);
                }
            }
        });
    }

    public static function pushSystemMenu(SystemMenu $systemMenu)
    {
        static::$system_menus[$systemMenu->code] = (array) $systemMenu;
    }

    public static function getOriginSystemMenu()
    {
        return static::$system_menus;
    }

    public static function getSystemMenuTree()
    {
        $cache_file_path = \config('cache.stores.file.path').'/system_menus_tree.php';
        $tree = null;
        if (! file_exists($cache_file_path)) {
            if (! static::$system_menus) {
                // 如果是空值那么猜测是缓存了路由
                // 这个时候就尝试刷新路由获取菜单树并缓存
                $route_cache_file = app()->getCachedRoutesPath();
                if (\file_exists($route_cache_file)) {
                    Artisan::call('route:cache');
                    $tree = ArrUtil::convertToTree(static::$system_menus, 'parent_code', 'code', 'children');
                    if ($tree) {
                        static::writeMenuTreeToCacheFile($tree);
                    }
                }
            }
            $tree ??= ArrUtil::convertToTree(static::$system_menus, 'parent_code', 'code', 'children');

            return $tree;
        }
        $tree = include_once $cache_file_path;

        return $tree;
    }

    public static function getSystemMenuList()
    {
        $cache_file_path = \config('cache.stores.file.path').'/system_menus.php';
        $menus = null;
        if (! file_exists($cache_file_path)) {
            if (! static::$system_menus) {
                // 如果是空值那么猜测是缓存了路由
                // 这个时候就尝试刷新路由获取菜单树并缓存
                $route_cache_file = app()->getCachedRoutesPath();
                if (\file_exists($route_cache_file)) {
                    Artisan::call('route:cache');
                    static::writeMenuToCacheFile(static::$system_menus);
                }
            }

            return static::$system_menus;
        }
        $menus = include_once $cache_file_path;

        return $menus;
    }

    public static function writeMenuTreeToCacheFile($tree)
    {
        $cache_file_path = \config('cache.stores.file.path').'/system_menus_tree.php';
        $treeCode = \var_export($tree, true);
        $file_content = <<<EOF
<?php

return $treeCode;
EOF;
        file_put_contents($cache_file_path, $file_content);
    }

    public static function writeMenuToCacheFile($menus)
    {
        $cache_file_path = \config('cache.stores.file.path').'/system_menus.php';
        $menusCode = \var_export($menus, true);
        $file_content = <<<EOF
<?php

return $menusCode;
EOF;
        file_put_contents($cache_file_path, $file_content);
    }

    public static function deleteCacheFile()
    {
        $cache_tree_file_path = \config('cache.stores.file.path').'/system_menus_tree.php';
        if (file_exists($cache_tree_file_path)) {
            unlink($cache_tree_file_path);
        }
        $cache_file_path = \config('cache.stores.file.path').'/system_menus.php';
        if (file_exists($cache_file_path)) {
            unlink($cache_file_path);
        }
    }

    private static function prefix($uri)
    {
        return trim(trim(Route::getLastGroupPrefix(), '/').'/'.trim($uri, '/'), '/') ?: '/';
    }
}
