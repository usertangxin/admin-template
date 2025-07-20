<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use Tests\TestCase;

class SystemAdminTest extends TestCase
{
    use RefreshDatabase;

    // /**
    //  * A basic test example.
    //  */
    // public function test_read(): void
    // {
    //     SystemAdminFactory::new()->create(['admin_name' => 'super admin']);
    //     $this->postJson('/web/admin/login', [
    //         'admin_name' => 'super admin',
    //         'password'   => '123456',
    //     ]);
    //     $response = $this->get('/web/admin/SystemAdmin/index?id=1', [
    //         "vary" => "X-Inertia",
    //         "X-Inertia" => true,
    //     ]);
    //     \dd($response);
    // }
}
