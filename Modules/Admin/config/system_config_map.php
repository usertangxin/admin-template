<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        "group" => 'map',
        "key" => "map_current",
        "value" => "amap",
        "name" => "当前地图",
        "input_type" => SystemConfigInputType::RADIO,
        "config_select_data" => [["label" => "高德地图", "value" => "amap"], ["label" => "腾讯地图", "value" => "tencent"]],
        "remark" => "",
        "bind_p_config" => "",
        "input_attr" => null
    ],
    [
        "group" => 'map',
        "key" => "tencent_key",
        "value" => "",
        "name" => "腾讯地图Key",
        "input_type" => SystemConfigInputType::INPUT,
        "config_select_data" => [],
        "remark" => "",
        "bind_p_config" => "map_current",
        "input_attr" => null
    ],
    [
        "group" => 'map',
        "key" => "amap_key",
        "value" => "3cedb1af3a2fd8080f6324e088d00ffe",
        "name" => "高德地图key",
        "input_type" => SystemConfigInputType::INPUT,
        "config_select_data" => null,
        "remark" => "",
        "bind_p_config" => "map_current",
        "input_attr" => null
    ],
    [
        "group" => 'map',
        "key" => "tencent_key",
        "value" => "60708b72732974b975e4135891e431ba",
        "name" => "腾讯地图key",
        "input_type" => SystemConfigInputType::INPUT,
        "config_select_data" => null,
        "remark" => "",
        "bind_p_config" => "map_current",
        "input_attr" => null
    ]
];
