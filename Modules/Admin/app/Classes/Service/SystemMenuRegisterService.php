<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Support\Facades\Route;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuType;
use Str;

class SystemMenuRegisterService
{

    public static $system_menus = [];

    private function __construct() {}

    public static function fastRoute($controller)
    {
        Route::controller($controller)->group(function () use ($controller) {
            $ref = new \ReflectionClass($controller);
            $methods = $ref->getMethods();
            $shortName = $ref->getShortName();
            $prefix = str_replace('Controller', '', $shortName);

            $ctlSystemMenuAttrs = $ref->getAttributes(SystemMenu::class);
            $ctlSystemMenuAttr =  null;
            if ($ctlSystemMenuAttrs) {
                $ctlSystemMenuAttr = $ctlSystemMenuAttrs[0]->newInstance();
                $ctlSystemMenuAttr->type ??= SystemMenuType::GROUP;
                $ctlSystemMenuAttr->code ??= $ref->getName();
                if(isset(static::$system_menus[$ctlSystemMenuAttr->code])) {
                    throw new \Exception('系统菜单编码重复');
                }
                static::$system_menus[$ctlSystemMenuAttr->code] = (array)$ctlSystemMenuAttr;
            }

            foreach ($methods as $method) {
                if ($method->isPublic() && !$method->isConstructor()) {
                    $name = $method->getName();
                    $actionName = $name;

                    $mtdSystemMenuAttr = $method->getAttributes(SystemMenu::class)[0]->newInstance();

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

                    $uri = $prefix . '/' . $actionName;
                    $routeName = $prefix . '.' . $actionName;
                    $fullUri = static::prefix($uri);

                    $mtdSystemMenuAttr->url = $fullUri;
                    $mtdSystemMenuAttr->type ??= SystemMenuType::ACTION;
                    $mtdSystemMenuAttr->code ??= $ref->getName() . '.' . $method->getName();
                    if ($method->getName() === 'index') {
                        $mtdSystemMenuAttr->parent_code ??= $ctlSystemMenuAttr?->code;
                    } else {
                        $mtdSystemMenuAttr->parent_code ??= $ref->getName() . '.index';
                    }
                    if(isset(static::$system_menus[$mtdSystemMenuAttr->code])) {
                        throw new \Exception('系统菜单编码重复');
                    }
                    static::$system_menus[$mtdSystemMenuAttr->code] = (array)$mtdSystemMenuAttr;

                    Route::$route_action($uri, [$controller, $name])->name($routeName);
                }
            }
        });
    }

    private static function prefix($uri)
    {
        return trim(trim(Route::getLastGroupPrefix(), '/') . '/' . trim($uri, '/'), '/') ?: '/';
    }
}
