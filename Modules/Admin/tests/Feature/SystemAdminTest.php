<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use Modules\Admin\Models\SystemAdmin;
use Modules\Admin\Tests\AbstractAuthTestCase;

class SystemAdminTest extends AbstractAuthTestCase
{
    public function test_update()
    {
        $admin             = SystemAdminFactory::new()->create();
        $old_password_hash = $admin->password;
        $response          = $this->postJson('/web/admin/SystemAdmin/update', [
            'id'         => $admin->id,
            'admin_name' => $admin->admin_name,
            'nickname'   => 'new nickname',
            // 测试为空时候不更新密码
            'password' => '',
            'status'   => 'normal',
            'data_scope_name' => 'all',
        ]);
        $admin->refresh();
        $response->assertJson(['code' => 0]);
        $this->assertEquals('new nickname', $admin->nickname);
        $this->assertEquals($old_password_hash, $admin->password);

        $response = $this->postJson('/web/admin/SystemAdmin/update', array_merge(
            Auth::user()->toArray(),
            // 测试无效状态
            ['status' => 'sdfg']
        ));
        $response->assertJson(['code' => 422]);

        $response = $this->postJson('/web/admin/SystemAdmin/update', array_merge(
            Auth::user()->toArray(),
            // 谁都不能更改根管理的状态
            ['status' => 'disabled', 'data_scope_name' => 'all']
        ));
        $response->assertJson(['code' => 500]);

        $this->auth($admin);
        $root_admin = SystemAdmin::where('is_root', true)->first();
        $response   = $this->postJson('/web/admin/SystemAdmin/update', array_merge(
            $root_admin->toArray(),
            // 测试其他管理修改根管理密码
            ['password' => '123456']
        ));
        $response->assertJson(['code' => 500]);
    }

    public function test_create()
    {
        $response = $this->postJson('/web/admin/SystemAdmin/create', [
            'admin_name' => 'new admin',
            'nickname'   => 'new nickname',
            'password'   => '123456',
            'status'     => 'normal',
            // 测试不能创建根管理
            'is_root' => true,
            'data_scope_name' => 'all',
        ]);
        $response->assertJson(['code' => 0]);
        $new_admin = SystemAdmin::where('admin_name', 'new admin')->first();
        $this->assertFalse($new_admin->is_root);
    }

    public function test_destroy()
    {
        // 根管理不允许被删除
        $response = $this->deleteJson('/web/admin/SystemAdmin/destroy', ['ids' => SystemAdmin::where('is_root', true)->first()->id]);
        $response->assertJson(['code' => 500]);
    }
}
