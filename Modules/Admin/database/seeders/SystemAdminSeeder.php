<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\SystemAdmin;
use Modules\Admin\Models\SystemAdminRole;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/system_admin.json'), true);
        foreach ($data as $item) {
            $model = SystemAdmin::find($item['id']);
            if (empty($model)) {
                $model = new SystemAdmin;
            }
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }

        $data = json_decode(file_get_contents(__DIR__ . '/json/system_admin_role.json'), true);
        foreach ($data as $item) {
            $model = SystemAdminRole::find($item['id']);
            if (! empty($model)) {
                continue;
            }
            $model = new SystemAdminRole;
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }
    }
}
