<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\SystemDictData;
use Modules\Admin\Models\SystemDictType;

class SystemDictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/json/system_dict_type.json'), true);
        foreach ($data as $item) {
            $model = SystemDictType::find($item['id']);
            if (empty($model)) {
                $model = new SystemDictType;
            }
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }

        $data = json_decode(file_get_contents(__DIR__.'/json/system_dict_data.json'), true);
        foreach ($data as $item) {
            $model = SystemDictData::find($item['id']);
            if (empty($model)) {
                $model = new SystemDictData;
            }
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }
    }
}
