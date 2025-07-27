<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Classes\Service\FileStorageService;
use Modules\Admin\Classes\Storage\Constraint\AudioConstraint;
use Modules\Admin\Classes\Storage\Constraint\DocumentConstraint;
use Modules\Admin\Classes\Storage\Constraint\FileConstraint;
use Modules\Admin\Classes\Storage\Constraint\ImageConstraint;
use Modules\Admin\Classes\Storage\Constraint\VideoConstraint;
use Modules\Admin\Classes\Storage\PublicStorage;

class FileStorageProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();
        $this->app->singleton(FileStorageService::class, function () {
            return new FileStorageService;
        });
    }

    public function boot(FileStorageService $fileStorageService): void
    {
        $fileStorageService->registerFileConstraint($this->app->make(FileConstraint::class));
        $fileStorageService->registerFileConstraint($this->app->make(ImageConstraint::class));
        $fileStorageService->registerFileConstraint($this->app->make(DocumentConstraint::class));
        $fileStorageService->registerFileConstraint($this->app->make(VideoConstraint::class));
        $fileStorageService->registerFileConstraint($this->app->make(AudioConstraint::class));

        $fileStorageService->registerFileStorage($this->app->make(PublicStorage::class));
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
