<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 注册任何应用程序服务。
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * 引导任何应用程序服务。
     */
    public function boot(): void
    {
        //
        if (app()->runningInConsole()) {
            if (!app()->runningConsoleCommand('optimize', 'config:cache')) {
                $replacements = config('modules.stubs.replacements');
                foreach ($replacements as $key => &$value) {
                    $value['SNAKE_NAME'] = fn (\Nwidart\Modules\Generators\ModuleGenerator $generator) => \Illuminate\Support\Str::snake($generator->getName());
                }
                Config::set('modules.stubs.replacements', $replacements);
            }
        }
    }
}
