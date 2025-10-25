<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group' => 'map',
        'key'   => 'map_current',
        'value' => 'amap',
        'name'  => [
            'zh_CN' => '当前地图',
            'en'    => 'Current Map',
        ],
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [['label' => '高德地图', 'value' => 'map_amap'], ['label' => '腾讯地图', 'value' => 'map_tencent']],
            ],
            'en' => [
                'options' => [['label' => 'Amap', 'value' => 'map_amap'], ['label' => 'Tencent', 'value' => 'map_tencent']],
            ],
        ],
    ],
    [
        'group' => 'map',
        'key'   => 'map_amap_code',
        'value' => '',
        'name'  => [
            'zh_CN' => '高德地图code',
            'en'    => 'Amap Code',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'map_current',
        'input_attr'    => null,
    ],
    [
        'group' => 'map',
        'key'   => 'map_amap_key',
        'value' => '',
        'name'  => [
            'zh_CN' => '高德地图key',
            'en'    => 'Amap Key',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'map_current',
        'input_attr'    => null,
    ],
    [
        'group' => 'map',
        'key'   => 'map_tencent_key',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯地图key',
            'en'    => 'Tencent Key',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'map_current',
        'input_attr'    => null,
    ],
];
