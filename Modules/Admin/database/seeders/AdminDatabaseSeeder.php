<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SystemMenuSeeder::class,
            SystemDeptSeeder::class,
            SystemAdminSeeder::class,
        ]);
    }
}
