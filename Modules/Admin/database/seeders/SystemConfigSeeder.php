<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemConfigGroup;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/system_config_group.json'), true);
        foreach ($data as $item) {
            $model = SystemConfigGroup::find($item['id']);
            if (empty($model)) {
                $model = new SystemConfigGroup();
            }
            foreach ($item as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }

        $data = json_decode(file_get_contents(__DIR__ . '/json/system_config.json'), true);
        foreach ($data as $item) {
            $model = SystemConfig::find($item['id']);
            if (empty($model)) {
                $model = new SystemConfig();
            }
            foreach ($item as $key => $value) {
                if ($key == 'value') {
                    continue;
                }
                $model->$key = $value;
            }
            $model->save();
        }
    }
}
