<?php

namespace Modules\Admin\Database\Seeders;

use Faker\Generator;
use Illuminate\Database\Seeder;
use Modules\Admin\Models\SystemAdmin;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        if (! SystemAdmin::count()) {
            $admin             = new SystemAdmin;
            $admin->admin_name = 'super admin';
            $admin->password   = 123456;
            $admin->nickname   = 'Super Admin';
            $admin->is_root    = true;
            $admin->phone      = $faker->phoneNumber;
            $admin->email      = $faker->email;
            $admin->save();
        }
    }
}
