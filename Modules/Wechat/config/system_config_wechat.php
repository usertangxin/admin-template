<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group' => 'wechat_config',
        'key'   => 'wechat_group',
        'value' => 'wechat_mini',
        'name'  => [
            'zh_CN' => '当前配置',
            'en'    => 'Current Configuration',
        ],
        'input_type'    => SystemConfigInputType::TABS,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '小程序', 'value' => 'wechat_mini'],
                    ['label' => '公众号', 'value' => 'wechat_official'],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Mini Program', 'value' => 'wechat_mini'],
                    ['label' => 'Official Account', 'value' => 'wechat_official'],
                ],
            ],
        ],
    ],
    [
        'group' => 'wechat_config',
        'key'   => 'wechat_mini_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => 'app id',
            'en'    => 'App ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信小程序app id',
            'en'    => 'WeChat Mini Program App ID',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_mini_secret',
        'value'      => '',
        'name'       => 'secret',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信小程序secret',
            'en'    => 'WeChat Mini Program Secret',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_official_app_id',
        'value'      => '',
        'name'       => 'app id',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信公众号app id',
            'en'    => 'WeChat Official Account App ID',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_official_secret',
        'value'      => '',
        'name'       => 'secret',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信公众号secret',
            'en'    => 'WeChat Official Account Secret',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
];
