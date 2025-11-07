<?php

namespace Modules\Admin\Providers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator as IlluminateValidator;
use Modules\Admin\Models\Scopes\GlobalDataPermissionScopeAll;
use Modules\Admin\Models\Scopes\GlobalDataPermissionScopeSelf;
use Modules\Admin\Models\SystemAdmin;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;
use Modules\Admin\Models\SystemDict;
use Modules\Admin\Models\SystemDictType;
use Modules\Admin\Observers\SystemConfigDictObserverObserver;
use Modules\Admin\Rules\BetweenArr;
use Modules\Admin\Rules\InDict;
use Modules\Admin\Services\AdminSupportService;
use Modules\Admin\Services\GlobalDataPermissionScopeService;
use Modules\Admin\Services\ResponseService;
use Modules\Admin\Services\SystemPermissionService;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

class AdminServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Admin';

    protected string $nameSnake = 'admin';

    /**
     * Boot the application events.
     */
    public function boot(GlobalDataPermissionScopeService $globalDataPermissionScopeService): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));

        Model::preventSilentlyDiscardingAttributes(app()->isLocal() || app()->runningUnitTests());

        SystemConfig::observe(SystemConfigDictObserverObserver::class);
        SystemConfigGroup::observe(SystemConfigDictObserverObserver::class);
        SystemDict::observe(SystemConfigDictObserverObserver::class);
        SystemDictType::observe(SystemConfigDictObserverObserver::class);

        $globalDataPermissionScopeService->add(new GlobalDataPermissionScopeAll);
        $globalDataPermissionScopeService->add(new GlobalDataPermissionScopeSelf);

        Validator::extend('in_dict', function ($attribute, $value, $parameters, IlluminateValidator $validator) {
            $rule = new InDict($parameters[0]);
            $rule->validate($attribute, $value, function ($message) use ($validator, $attribute) {
                $validator->errors()->add($attribute, $message);
            });

            return true;
        });

        Validator::extend('between_arr', function ($attribute, $value, $parameters, IlluminateValidator $validator) {
            $rule = new BetweenArr($parameters[0], $parameters[1]);
            $rule->validate($attribute, $value, function ($message) use ($validator, $attribute) {
                $validator->errors()->add($attribute, $message);
            });

            return true;
        });

        Gate::before(function ($user, $ability) {
            if ($user instanceof SystemAdmin) {
                if ($user->is_root) {
                    return true;
                }

                $menu = SystemPermissionService::getInstance()->getBy($ability, 'code');

                if ($menu['allow_all'] ?? false) {
                    return true;
                }

                if ($menu['allow_admin'] ?? false) {
                    return true;
                }
            }

            return null;
        });
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->singleton(AdminSupportService::class);
        $this->app->singleton(GlobalDataPermissionScopeService::class);
        $this->withExceptions();
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/' . $this->nameSnake);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameSnake);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameSnake);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config     = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments   = explode('.', $this->nameSnake . '.' . $config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameSnake : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($key . '.php')], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    private function withExceptions(): void
    {
        app()->resolving(\Illuminate\Foundation\Exceptions\Handler::class, function ($handler) {
            $exceptions = new Exceptions($handler);
            $exceptions->render(function (\Illuminate\Validation\ValidationException $exception, Request $request) {
                if (app(AdminSupportService::class)->isAdminBackground()) {
                    $messages = implode('', Arr::flatten($exception->errors()));

                    return ResponseService::fail($messages, $exception->status, 'module.Admin.500', $exception->errors());
                }
            });

            $exceptions->render(function (NotFoundResourceException $exception, Request $request) {
                if (app(AdminSupportService::class)->isAdminBackground()) {
                    return ResponseService::fail($exception->getMessage(), 404, null, []);
                }
            });

            $exceptions->render(function (AuthenticationException $exception, Request $request) {
                if (app(AdminSupportService::class)->isAdminBackground()) {
                    return redirect()->route('web.admin.login.view');
                }
            });

            $exceptions->render(function (Throwable $exception, Request $request) {
                if (app(AdminSupportService::class)->isAdminBackground()) {
                    return ResponseService::fail($exception->getMessage(), 500, 'module.Admin.500', app()->isLocal() ? ['trace' => $exception->getTrace()] : []);
                }
            });
        });
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $this->replaceConfigRecursivelyFrom($path, $key);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath   = resource_path('views/modules/' . $this->nameSnake);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameSnake . '_module_views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameSnake);

        Blade::componentNamespace(config('modules.namespace') . '\\' . $this->name . '\\View\\Components', $this->nameSnake);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->nameSnake)) {
                $paths[] = $path . '/modules/' . $this->nameSnake;
            }
        }

        return $paths;
    }
}
