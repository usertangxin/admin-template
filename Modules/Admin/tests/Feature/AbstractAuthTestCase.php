<?php

namespace Modules\Admin\Tests\Feature;

use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use Modules\Admin\Models\SystemAdmin;
use Tests\TestCase;

class AbstractAuthTestCase extends TestCase
{
    use RefreshDatabase;

    protected $autoAuth = true;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('admin:module install all');

        if ($this->autoAuth) {
            $this->auth();
        }
    }

    protected function auth($admin = null, $guard = 'admin')
    {
        $admin = $admin ?? SystemAdmin::find(1);
        $admin->refresh();

        return $this->actingAs($admin, $guard);
    }
}
