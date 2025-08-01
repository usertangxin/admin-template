<?php

namespace Modules\Admin\Classes\Utils;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteUtil
{
    public static function fastRoute($controller)
    {
        Route::controller($controller)->group(function () use ($controller) {
            $ref            = new \ReflectionClass($controller);
            $methods        = $ref->getMethods();
            $shortName      = $ref->getShortName();
            $ignore_actions = [];
            $ignore_methods = [];
            if ($ref->hasConstant('IGNORE_ACTIONS')) {
                $ignore_actions = $ref->getConstant('IGNORE_ACTIONS');
            }
            if ($ref->hasConstant('IGNORE_METHODS')) {
                $ignore_methods = $ref->getConstant('IGNORE_METHODS');
            }
            $prefix = str_replace('Controller', '', $shortName);

            foreach ($methods as $method) {
                if ($method->isPublic() && ! $method->isConstructor()) {
                    $name = $method->getName();
                    if (in_array($name, $ignore_methods)) {
                        continue;
                    }
                    $actionName   = $name;
                    $route_action = 'any';
                    $actions      = ['get', 'post', 'put', 'delete', 'patch'];
                    foreach ($actions as $action) {
                        if (str_starts_with($actionName, $action)) {
                            $route_action = $action;
                            $actionName   = str_replace($action . '', '', $actionName);
                            $actionName   = Str::lcfirst($actionName);
                            break;
                        }
                    }
                    if (in_array($actionName, $ignore_actions)) {
                        continue;
                    }

                    $uri       = $prefix . '/' . Str::kebab($actionName);
                    $routeName = $prefix . '.' . Str::kebab($actionName);

                    /** @var \Illuminate\Routing\Route $route */
                    $route = Route::$route_action($uri, [$controller, $name])->name($routeName);
                }
            }
        });
    }
}
