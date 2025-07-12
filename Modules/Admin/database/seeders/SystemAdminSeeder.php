<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\SystemAdmin;
use Modules\Admin\Models\SystemAdminRole;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!SystemAdmin::count()) {
            $admin = new SystemAdmin();
            $admin->admin_name = 'super admin';
            $admin->password = Hash::make('123456');
            $admin->nickname = 'Super Admin';
            $admin->save();
        }
    }
}
