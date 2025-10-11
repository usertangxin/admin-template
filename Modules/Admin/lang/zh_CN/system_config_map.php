<?php

return [
    'map_current' => [
        'name'       => '当前地图',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => '高德地图', 'value' => 'amap'],
                ['label' => '腾讯地图', 'value' => 'tencent'],
            ],
        ],
    ],
    'amap_code' => [
        'name'  => '高德地图code',

        'remark'     => '',
        'input_attr' => null,
    ],
    'amap_key' => [
        'name'  => '高德地图key',

        'remark'     => '',
        'input_attr' => null,
    ],
    'tencent_key' => [
        'name'  => '腾讯地图key',

        'remark'     => '',
        'input_attr' => null,
    ],
];
