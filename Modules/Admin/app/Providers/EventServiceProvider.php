<?php

namespace Modules\Admin\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Admin\Listeners\ModuleEventSubscriber;
use Modules\Admin\Listeners\SystemAdminLogin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        Login::class => [
            SystemAdminLogin::class,
        ],
        'modules.*.enabled' => [
            [ModuleEventSubscriber::class, 'onEnabled'],
        ],
        'modules.*.disabling' => [
            [ModuleEventSubscriber::class, 'onDisabling'],
        ],
        'modules.*.deleting' => [
            [ModuleEventSubscriber::class, 'onDeleting'],
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
