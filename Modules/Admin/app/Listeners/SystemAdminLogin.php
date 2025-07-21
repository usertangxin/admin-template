<?php

namespace Modules\Admin\Listeners;

use Illuminate\Auth\Events\Login;
use Modules\Admin\Models\SystemAdmin;

class SystemAdminLogin
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if ($event->user instanceof SystemAdmin) {
            $event->user->login_ip = \request()->ip();
            $event->user->login_at = now();
            $event->user->save();
        }
    }
}
