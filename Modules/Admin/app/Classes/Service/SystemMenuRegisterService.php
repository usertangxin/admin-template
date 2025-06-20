<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Support\Facades\Route;
use Str;

class SystemMenuRegisterService
{
    private function __construct() {}

    public static function fastRoute($controller)
    {
        Route::controller($controller)->group(function () use ($controller) {
            $ref = new \ReflectionClass($controller);
            $methods = $ref->getMethods();
            $shortName = $ref->getShortName();
            $prefix = str_replace('Controller', '', $shortName);
            foreach ($methods as $method) {
                if ($method->isPublic() && !$method->isConstructor()) {
                    $name = $method->getName();
                    $routeName = $name;

                    $route_action = 'any';
                    $actions = ['get', 'post', 'put', 'delete', 'patch'];
                    foreach ($actions as $action) {
                        if (str_starts_with($routeName, $action)) {
                            $route_action = $action;
                            $routeName = str_replace($action . '', '', $routeName);
                            $routeName = Str::lcfirst($routeName);
                            break;
                        }
                    }

                    Route::$route_action($prefix . '/' . $routeName, [$controller, $name])->name($prefix . '.' . $routeName);
                }
            }
        });
    }
}
