<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use Tests\TestCase;

class SystemAdminTest extends AbstractAuthTestCase
{
    public function test_update()
    {
        $admin = SystemAdminFactory::new()->create();
        $old_password_hash = $admin->password;
        $response = $this->postJson('/web/admin/SystemAdmin/update', [
            'id' => $admin->id,
            'admin_name' => $admin->admin_name,
            'nickname' => 'new nickname',
            'password' => '',
            'status' => 'normal',
        ]);
        $admin->refresh();
        $response->assertJson(['code' => 0]);
        $this->assertEquals('new nickname', $admin->nickname);
        $this->assertEquals($old_password_hash, $admin->password);
    }
}
