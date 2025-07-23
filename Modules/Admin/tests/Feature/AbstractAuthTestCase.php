<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use Tests\TestCase;

class AbstractAuthTestCase extends TestCase
{
    use RefreshDatabase;

    protected $autoAuth = true;

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->autoAuth) {
            $this->auth();
        }
    }

    protected function auth($admin = null, $guard = 'admin')
    {
        $admin = $admin ?? SystemAdminFactory::new()->create(['admin_name' => 'super admin']);

        return $this->actingAs($admin, $guard);
    }
}
