<?php

namespace Modules\Admin\Tests\Unit;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Database\Factories\SystemAdminFactory;
use Modules\Admin\Services\SystemPermissionService;
use Modules\Admin\Tests\AbstractAuthTestCase;

class SystemMenuServiceTest extends AbstractAuthTestCase
{
    public function test_get_my_permission_tree(): void
    {
        $admin = SystemAdminFactory::new()->create();
        $this->auth($admin);
        $permission = 'web.admin.CrudTest.index';
        $role       = Role::where('name', 'admin')->firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        $role->givePermissionTo($permission);
        $admin->assignRole('admin');

        $menuService = \app(SystemPermissionService::class);
        $tree        = $menuService->getMyPermissionTree();

        // \dd(Auth::user()->getAllPermissions()->pluck('name')->toArray());

        $json = json_encode($tree, JSON_UNESCAPED_UNICODE);
        $this->assertStringContainsString($permission, $json);
        $this->assertStringNotContainsString('web.admin.CrudTest.read', $json);

        $this->assertTrue($admin->can('web.admin.index'));
    }
}
