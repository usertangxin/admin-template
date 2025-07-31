<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Filesystem\FilesystemServiceProvider as IlluminateFilesystemServiceProvider;
use Illuminate\Filesystem\ServeFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * 将其置于最后执行加载最新磁盘路由
 */
class FilesystemServiceProvider extends IlluminateFilesystemServiceProvider
{
    /**
     * Register protected file serving.
     *
     * @return void
     */
    protected function serveFiles()
    {
        if ($this->app instanceof CachesRoutes && $this->app->routesAreCached()) {
            return;
        }

        $this->app->booted(function ($app) {
            foreach ($app['config']['filesystems.disks'] ?? [] as $disk => $config) {
                if (! $this->shouldServeFiles($config)) {
                    continue;
                }
                $uri = isset($config['url'])
                    ? rtrim(parse_url($config['url'])['path'], '/')
                    : '/storage';

                $isProduction = $app->isProduction();

                Route::get($uri . '/{path}', function (Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                })->where('path', '.*')->name('storage.' . $disk);
            }
        });
    }
}
