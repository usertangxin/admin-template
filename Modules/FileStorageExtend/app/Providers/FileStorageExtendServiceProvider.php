<?php

namespace Modules\FileStorageExtend\Providers;

use Iidestiny\Flysystem\Oss\OssAdapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Modules\Admin\Services\FileStorageService;
use Modules\FileStorageExtend\Classes\Storage\OSSStorage;
use Modules\FileStorageExtend\Classes\Storage\QiniuStorage;
use Nwidart\Modules\Traits\PathNamespace;
use Overtrue\Flysystem\Cos\CosAdapter;
use Overtrue\Flysystem\Qiniu\QiniuAdapter;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileStorageExtendServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'FileStorageExtend';

    protected string $nameSnake = 'file_storage_extend';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        // $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));

        $this->extendOss();
        $this->extendQiniu();

        app()->booted(function () {
            app(FileStorageService::class)->registerFileStorage($this->app->make(OSSStorage::class));
            app(FileStorageService::class)->registerFileStorage($this->app->make(QiniuStorage::class));
        });
    }

    private function extendOss()
    {
        Storage::extend('oss', function (Application $app, array $config) {
            $prefix = $config['prefix'] ?? ''; // 前缀，非必填
            $accessKeyId = $config['accessKeyId'] ?? '';
            $accessKeySecret = $config['accessKeySecret'] ?? '';
            $endpoint = $config['endpoint'] ?? ''; // ssl：https://iidestiny.com
            $bucket = $config['bucket'] ?? '';
            $isCName = $config['isCName'] ?? false; // 如果 isCname 为 false，endpoint 应配置 oss 提供的域名如：`oss-cn-beijing.aliyuncs.com`，cname 或 cdn 请自行到阿里 oss 后台配置并绑定 bucket
            $adapter = new OssAdapter($accessKeyId, $accessKeySecret, $endpoint, $bucket, $isCName, $prefix);

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }

    private function extendQiniu()
    {
        Storage::extend('qiniu', function (Application $app, array $config) {
            $accessKey = $config['accessKey'] ?? '';
            $secretKey = $config['secretKey'] ?? '';
            $bucket = $config['bucket'] ?? '';
            $domain = $config['domain'] ?? ''; // or with protocol: https://xxxx.bkt.clouddn.com

            $adapter = new QiniuAdapter($accessKey, $secretKey, $bucket, $domain);

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }

    private function extendCos()
    {
        Storage::extend('cos', function (Application $app, array $config) {
            $a = [
                // 必填，app_id、secret_id、secret_key 
                // 可在个人秘钥管理页查看：https://console.cloud.tencent.com/capi
                'app_id' => $config['app_id'] ?? '',
                'secret_id' => $config['secret_id'] ?? '',
                'secret_key' => $config['secret_key'] ?? '',

                'region' => $config['region'] ?? '',
                'bucket' => $config['bucket'] ?? '',

                // 可选，如果 bucket 为私有访问请打开此项
                'signed_url' => $config['signed_url'] ?? false,

                // 可选，是否使用 https，默认 false
                'use_https' => $config['use_https'] ?? true,

                // 可选，自定义域名
                'domain' => $config['domain'] ?? '',

                // 可选，使用 CDN 域名时指定生成的 URL host
                'cdn' => $config['cdn'] ?? '',
            ];

            $adapter = new CosAdapter($a);

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
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
