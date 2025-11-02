<?php

use Modules\Admin\Casts\AsCommaArray;
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
        'key'        => 'wechat_mini_token',
        'value'      => '',
        'name'       => 'token',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信小程序token',
            'en'    => 'WeChat Mini Program token',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_mini_aes_key',
        'value'      => '',
        'name'       => 'aes_key',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信小程序aes key',
            'en'    => 'WeChat Mini Program aes key',
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
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_official_token',
        'value'      => '',
        'name'       => 'token',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信公众号token',
            'en'    => 'WeChat Official Account Token',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_official_aes_key',
        'value'      => '',
        'name'       => 'aes key',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信公众号aes key',
            'en'    => 'WeChat Official Account AES Key',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'wechat_config',
        'name'  => [
            'zh_CN' => 'OAuth 配置',
            'en'    => 'OAuth Configuration',
        ],
        'input_type'    => SystemConfigInputType::DIVIDER,
        'key'           => 'wechat_official_oauth_divider',
        'bind_p_config' => 'wechat_group',
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_official_oauth_scopes',
        'value'      => 'snsapi_userinfo,snsapi_base',
        'value_cast' => AsCommaArray::class,
        'name'       => [
            'zh_CN' => 'OAuth 授权范围',
            'en'    => 'OAuth Authorization Scope',
        ],
        'input_type'    => SystemConfigInputType::CHECKBOX,
        'remark'        => '',
        'bind_p_config' => 'wechat_group',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => 'snsapi_userinfo', 'value' => 'snsapi_userinfo'],
                    ['label' => 'snsapi_base', 'value' => 'snsapi_base'],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'snsapi_userinfo', 'value' => 'snsapi_userinfo'],
                    ['label' => 'snsapi_base', 'value' => 'snsapi_base'],
                ],
            ],
        ],
    ],
    [
        'group'      => 'wechat_config',
        'key'        => 'wechat_official_redirect_url',
        'value'      => '',
        'name'       => 'redirect url',
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信公众号回调地址',
            'en'    => 'WeChat Official Account Callback URL',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
];