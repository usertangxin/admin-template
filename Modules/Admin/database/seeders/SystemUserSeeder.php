<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\SystemUser;
use Modules\Admin\Models\SystemUserRole;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/system_user.json'), true);
        foreach ($data as $item) {
            $model = SystemUser::find($item['id']);
            if (empty($model)) {
                $model = new SystemUser();
            }
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }

        $data = json_decode(file_get_contents(__DIR__ . '/json/system_user_role.json'), true);
        foreach ($data as $item) {
            $model = SystemUserRole::find($item['id']);
            if (!empty($model)) {
                continue;
            }
            $model = new SystemUserRole();
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }
    }
}
