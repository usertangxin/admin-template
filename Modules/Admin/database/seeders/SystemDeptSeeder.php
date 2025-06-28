<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\SystemDept;

class SystemDeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/json/system_dept.json'), true);
        foreach ($data as $item) {
            $model = SystemDept::find($item['id']);
            if (empty($model)) {
                $model = new SystemDept;
            }
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }
    }
}
