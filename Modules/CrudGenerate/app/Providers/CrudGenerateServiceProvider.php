<?php

namespace Modules\CrudGenerate\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\CrudGenerate\Classes\FieldControlBigIncrements;
use Modules\CrudGenerate\Classes\FieldControlBoolean;
use Modules\CrudGenerate\Classes\FieldControlDateTime;
use Modules\CrudGenerate\Classes\FieldControlEnum;
use Modules\CrudGenerate\Classes\FieldControlEnumDict;
use Modules\CrudGenerate\Classes\FieldControlInteger;
use Modules\CrudGenerate\Classes\FieldControlJson;
use Modules\CrudGenerate\Classes\FieldControlLongText;
use Modules\CrudGenerate\Classes\FieldControlString;
use Modules\CrudGenerate\Classes\FieldControlText;
use Modules\CrudGenerate\Classes\FieldControlUnsignedBigInteger;
use Modules\CrudGenerate\Classes\FieldControlUnsignedInteger;
use Modules\CrudGenerate\Classes\FieldControlUuid;
use Modules\CrudGenerate\Classes\PageViewControlCheckBox;
use Modules\CrudGenerate\Classes\PageViewControlDatePicker;
use Modules\CrudGenerate\Classes\PageViewControlInput;
use Modules\CrudGenerate\Classes\PageViewControlInputNumber;
use Modules\CrudGenerate\Classes\PageViewControlInputRange;
use Modules\CrudGenerate\Classes\PageViewControlRate;
use Modules\CrudGenerate\Classes\PageViewControlSelect;
use Modules\CrudGenerate\Classes\PageViewControlSlider;
use Modules\CrudGenerate\Classes\PageViewControlSwitch;
use Modules\CrudGenerate\Classes\PageViewControlTimePicker;
use Modules\CrudGenerate\Services\FieldControlService;
use Modules\CrudGenerate\Services\PageViewControlService;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CrudGenerateServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'CrudGenerate';

    protected string $nameSnake = 'crud_generate';

    /**
     * Boot the application events.
     */
    public function boot(FieldControlService $fieldControlService, PageViewControlService $pageViewControlService): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));

        $fieldControlService->add(new FieldControlInteger);
        $fieldControlService->add(new FieldControlUnsignedInteger);
        $fieldControlService->add(new FieldControlUnsignedBigInteger);
        $fieldControlService->add(new FieldControlBigIncrements);
        $fieldControlService->add(new FieldControlString);
        $fieldControlService->add(new FieldControlText);
        $fieldControlService->add(new FieldControlLongText);
        $fieldControlService->add(new FieldControlJson);
        $fieldControlService->add(new FieldControlEnum);
        $fieldControlService->add(new FieldControlEnumDict);
        $fieldControlService->add(new FieldControlBoolean);
        $fieldControlService->add(new FieldControlDateTime);
        $fieldControlService->add(new FieldControlUuid);

        $pageViewControlService->add(new PageViewControlInput);
        $pageViewControlService->add(new PageViewControlInputNumber);
        $pageViewControlService->add(new PageViewControlInputRange);
        $pageViewControlService->add(new PageViewControlCheckBox);
        $pageViewControlService->add(new PageViewControlSwitch);
        $pageViewControlService->add(new PageViewControlSelect);
        $pageViewControlService->add(new PageViewControlDatePicker);
        $pageViewControlService->add(new PageViewControlTimePicker);
        $pageViewControlService->add(new PageViewControlRate);
        $pageViewControlService->add(new PageViewControlSlider);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(FieldControlService::class);
        $this->app->singleton(PageViewControlService::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
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

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing      = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($module_config, $existing)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath   = resource_path('views/modules/' . $this->nameSnake);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameSnake . '-module-views']);

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
