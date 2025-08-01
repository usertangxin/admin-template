<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Admin\Classes\Attrs\SystemMenu as AttrsSystemMenu;
use Modules\Admin\Http\Controllers\AbstractController;
use Modules\Admin\Models\SystemMenu;

class SystemMenuManager
{
    public static function autoRegister(mixed $menu)
    {
        $arr = [];
        if (! is_array($menu)) {
            $arr[] = $menu;
        } else {
            $arr = $menu;
        }
        foreach ($arr as $item) {
            SystemMenu::whereCode($item['code'])->firstOr(function () use ($item) {
                $item               = (array) $item;
                $model              = new SystemMenu;
                $model->code        = $item['code'];
                $model->name        = $item['name'];
                $model->icon        = $item['icon'];
                $model->parent_code = $item['parent_code'];
                $model->type        = $item['type'];
                $model->url         = $item['url'];
                $model->remark      = $item['remark'] ?? '';
                $model->save();
            });
        }
    }

    public static function collection()
    {
        $arr    = [];
        $routes = Route::getRoutes();
        $routes = $routes->getRoutes();
        foreach ($routes as $route) {
            if ($controller = $route->getController()) {
                if ($controller instanceof AbstractController) {
                    $action = $route->getActionName();
                    $ref    = new \ReflectionMethod(Str::of($action)->replace('@', '::')->toString());
                    if (! empty($ref->getAttributes(AttrsSystemMenu::class))) {
                        $systemMenuAttr = $ref->getAttributes(AttrsSystemMenu::class)[0]->newInstance();
                        $parent_code    = $systemMenuAttr->parent_code;
                        $type           = $systemMenuAttr->type;
                        $name           = $systemMenuAttr->name;
                        $icon           = $systemMenuAttr->icon;
                        if ($ref->getName() == 'index') {
                            $type   = SystemMenuType::MENU;
                            $ctrRef = new \ReflectionClass($controller);
                            if (! empty($ctrRef->getAttributes(AttrsSystemMenu::class))) {
                                $ctrSystemMenuAttr = $ctrRef->getAttributes(AttrsSystemMenu::class)[0]->newInstance();
                                $parent_code       = $ctrSystemMenuAttr->parent_code;
                                $name              = $ctrSystemMenuAttr->name;
                                $icon              = $ctrSystemMenuAttr->icon;
                            }
                        } else {
                            $parent_code ??= \substr($route->getName(), 0, \strrpos($route->getName(), '.')) . '.index';
                        }
                        $arr[] = [
                            'code'        => $route->getName(),
                            'name'        => $name,
                            'icon'        => $icon,
                            'parent_code' => $parent_code,
                            'type'        => $type,
                            'url'         => $route->uri(),
                        ];
                    }
                }
            }
        }

        return $arr;
    }
}
