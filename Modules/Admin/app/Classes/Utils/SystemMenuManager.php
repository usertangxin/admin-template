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
        if (! is_array($menu) || ! isset($menu[0])) {
            $arr[] = $menu;
        } else {
            $arr = $menu;
        }
        foreach ($arr as $item) {
            $model = SystemMenu::whereCode($item['code'])->first();
            if (! $model) {
                $model = new SystemMenu;
            }

            $item        = (array) $item;
            $model->code = $item['code'];
            foreach (config('admin.multi_language') as $lang) {
                $name = $item['name'];
                if (! empty($item['name_lang']) && \Lang::has($item['name_lang'], $lang)) {
                    $name_lang = __($item['name_lang'], locale: $lang);
                    if ($name_lang) {
                        $name = $name_lang;
                    }
                }
                $model->setTranslation('name', $lang, $name);
            }
            $model->icon            = $item['icon'];
            $model->parent_code     = $item['parent_code'];
            $model->type            = $item['type'];
            $model->url             = $item['url'];
            $model->is_auto_collect = $item['is_auto_collect'] ?? false;
            $model->remark          = $item['remark'] ?? '';
            $model->is_hidden       = $item['is_hidden'] ?? false;
            $model->allow_all       = $item['allow_all'] ?? false;
            $model->allow_admin     = $item['allow_admin'] ?? false;
            $model->save();
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
                    $controller_namespace = get_class($controller);

                    $action = $route->getActionName();
                    $ref    = new \ReflectionMethod(Str::of($action)->replace('@', '::')->toString());
                    if (! empty($ref->getAttributes(AttrsSystemMenu::class))) {
                        $systemMenuAttr = $ref->getAttributes(AttrsSystemMenu::class)[0]->newInstance();
                        $parent_code    = $systemMenuAttr->parent_code;
                        $type           = $systemMenuAttr->type ?? SystemMenuType::ACTION;
                        $name           = $systemMenuAttr->name;
                        $icon           = $systemMenuAttr->icon;

                        $ctrRef = new \ReflectionClass($controller);
                        if (! empty($ctrRef->getAttributes(AttrsSystemMenu::class))) {
                            $ctrSystemMenuAttr = $ctrRef->getAttributes(AttrsSystemMenu::class)[0]->newInstance();
                        }
                        if ($ref->getName() == 'index') {
                            $type = SystemMenuType::MENU;
                            if (isset($ctrSystemMenuAttr)) {
                                $parent_code = $ctrSystemMenuAttr->parent_code;
                                $name        = $ctrSystemMenuAttr->name;
                                $icon        = $ctrSystemMenuAttr->icon;
                            }
                        } elseif (empty($parent_code)) {
                            if ($ctrRef->hasMethod('index')) {
                                $parent_code = \substr($route->getName(), 0, \strrpos($route->getName(), '.')) . '.index';
                            } elseif (isset($ctrSystemMenuAttr)) {
                                $parent_code = $ctrSystemMenuAttr->parent_code;
                            }
                        }

                        $name_lang = $systemMenuAttr->name_lang;

                        if (is_null($name_lang)) {
                            if (str_starts_with($controller_namespace, config('modules.namespace'))) {
                                $moduleParts = explode('\\', $controller_namespace);
                                $moduleName  = Str::snake($moduleParts[1]);
                                $name_lang   = $moduleName . '::' . 'system_menu.' . Str::snake(class_basename($controller)) . '.' . Str::snake($route->getActionMethod());
                            }
                        }

                        $arr[] = [
                            'code'            => $route->getName(),
                            'name'            => $name,
                            'icon'            => $icon,
                            'parent_code'     => $parent_code,
                            'type'            => $type,
                            'url'             => $route->uri(),
                            'is_auto_collect' => true,
                            'is_hidden'       => $systemMenuAttr->is_hidden,
                            'allow_all'       => $systemMenuAttr->allow_all,
                            'allow_admin'     => $systemMenuAttr->allow_admin,
                            'name_lang'       => $name_lang,
                        ];
                    }
                }
            }
            unset($ctrRef);
            unset($ctrSystemMenuAttr);
        }

        return $arr;
    }
}
