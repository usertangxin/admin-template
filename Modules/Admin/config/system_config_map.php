<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group'         => 'map',
        'key'           => 'map_current',
        'value'         => 'amap',
        'name'          => '当前地图',
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'options' => [['label' => '高德地图', 'value' => 'amap'], ['label' => '腾讯地图', 'value' => 'tencent']],
        ],
    ],
    [
        'group'      => 'map',
        'key'        => 'amap_code',
        'value'      => '',
        'name'       => '高德地图code',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'map_current',
        'input_attr'    => null,
    ],
    [
        'group'      => 'map',
        'key'        => 'amap_key',
        'value'      => '',
        'name'       => '高德地图key',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'map_current',
        'input_attr'    => null,
    ],
    [
        'group'      => 'map',
        'key'        => 'tencent_key',
        'value'      => '',
        'name'       => '腾讯地图key',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'map_current',
        'input_attr'    => null,
    ],
];
