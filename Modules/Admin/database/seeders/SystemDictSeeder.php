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
        // $a = [];
        // foreach ($data as $item) {
        //     $a[$item['code']] ??= [];
        //     $a[$item['code']][] = [
        //         'label'  => $item['label'],
        //         'value'  => $item['value'],
        //         'code'   => $item['code'],
        //         'remark' => $item['remark'],
        //     ];
        // }
        // foreach ($a as $key => $item) {
        //     $c = \var_export(\array_values($item), true);
        //     $b = <<<EOT
        //     <?php 
        //     return $c;
        //     EOT;
        //     file_put_contents(__DIR__.'/json/system_dict_data_'.$key.'.php', $b);
        // }
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
