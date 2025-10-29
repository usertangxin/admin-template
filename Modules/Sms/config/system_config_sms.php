<?php

use Modules\Admin\Casts\AsBoolean;
use Modules\Admin\Casts\AsInteger;
use Modules\Admin\Classes\Utils\SystemConfigInputType;
use Modules\Sms\Classes\AliyunIntlLoadConfig;
use Modules\Sms\Classes\AliyunLoadConfig;
use Modules\Sms\Classes\OrderStrategy;
use Modules\Sms\Classes\QcloudLoadConfig;
use Modules\Sms\Classes\QiniuLoadConfig;

return [
    [
        'group' => 'sms',
        'key'   => 'sms_gateways',
        'value' => 'sms_aliyun_',
        'name'  => [
            'zh_CN' => '短信网关',
            'en'    => 'Sms Gateway',
        ],
        'input_type'    => SystemConfigInputType::TABS,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '阿里云', 'value' => 'sms_aliyun_', 'load_config' => AliyunLoadConfig::class],
                    ['label' => '阿里云国际', 'value' => 'sms_aliyunintl_', 'load_config' => AliyunIntlLoadConfig::class],
                    ['label' => '腾讯云', 'value' => 'sms_qcloud_', 'load_config' => QcloudLoadConfig::class],
                    ['label' => '七牛云', 'value' => 'sms_qiniu_', 'load_config' => QiniuLoadConfig::class],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Aliyun', 'value' => 'sms_aliyun_', 'load_config' => AliyunLoadConfig::class],
                    ['label' => 'Aliyun Intl', 'value' => 'sms_aliyunintl_', 'load_config' => AliyunIntlLoadConfig::class],
                    ['label' => 'Tencent', 'value' => 'sms_qcloud_', 'load_config' => QcloudLoadConfig::class],
                    ['label' => 'Qiniu', 'value' => 'sms_qiniu_', 'load_config' => QiniuLoadConfig::class],
                ],
            ],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | 阿里云
    |--------------------------------------------------------------------------
    */
    [
        'group'      => 'sms',
        'key'        => 'sms_aliyun_status',
        'value'      => false,
        'value_cast' => AsBoolean::class,
        'name'       => [
            'zh_CN' => '阿里云状态',
            'en'    => 'Aliyun Status',
        ],
        'input_type'    => SystemConfigInputType::SWITCH,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group'      => 'sms',
        'key'        => 'sms_aliyun_sort_order',
        'value'      => 1,
        'value_cast' => AsInteger::class,
        'name'       => [
            'zh_CN' => '阿里云优先级',
            'en'    => 'Aliyun Priority',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_aliyun_access_key_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里云AccessKeyID',
            'en'    => 'Aliyun Access Key ID',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_aliyun_access_key_secret',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里云AccessKeySecret',
            'en'    => 'Aliyun Access Key Secret',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_aliyun_sign_name',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里云SignName',
            'en'    => 'Aliyun Sign Name',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | 阿里云国际
    |--------------------------------------------------------------------------
    */
    [
        'group'      => 'sms',
        'key'        => 'sms_aliyunintl_status',
        'value'      => false,
        'value_cast' => AsBoolean::class,
        'name'       => [
            'zh_CN' => '阿里云国际状态',
            'en'    => 'Aliyun Intl Status',
        ],
        'input_type'    => SystemConfigInputType::SWITCH,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group'      => 'sms',
        'key'        => 'sms_aliyunintl_sort_order',
        'value'      => 1,
        'value_cast' => AsInteger::class,
        'name'       => [
            'zh_CN' => '阿里云国际优先级',
            'en'    => 'Aliyun Intl Priority',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_aliyunintl_access_key_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里云国际AccessKeyID',
            'en'    => 'Aliyun Intl Access Key ID',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_aliyunintl_access_key_secret',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里云国际AccessKeySecret',
            'en'    => 'Aliyun Intl Access Key Secret',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_aliyunintl_sign_name',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里云国际SignName',
            'en'    => 'Aliyun Intl Sign Name',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | 腾讯云
    |--------------------------------------------------------------------------
    */
    [
        'group'      => 'sms',
        'key'        => 'sms_qcloud_status',
        'value'      => false,
        'value_cast' => AsBoolean::class,
        'name'       => [
            'zh_CN' => '腾讯云状态',
            'en'    => 'Tencent Cloud Status',
        ],
        'input_type'    => SystemConfigInputType::SWITCH,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group'      => 'sms',
        'key'        => 'sms_qcloud_sort_order',
        'value'      => 1,
        'value_cast' => AsInteger::class,
        'name'       => [
            'zh_CN' => '腾讯云优先级',
            'en'    => 'Tencent Cloud Priority',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_qcloud_sdk_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯云SDKAppID',
            'en'    => 'Tencent Cloud SDK App ID',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_qcloud_secret_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯云SecretId',
            'en'    => 'Tencent Cloud Secret ID',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_qcloud_secret_key',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯云SecretKey',
            'en'    => 'Tencent Cloud Secret Key',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_qcloud_sign_name',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯云SignName',
            'en'    => 'Tencent Cloud Sign Name',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | 七牛云
    |--------------------------------------------------------------------------
    */
    [
        'group'      => 'sms',
        'key'        => 'sms_qiniu_status',
        'value'      => false,
        'value_cast' => AsBoolean::class,
        'name'       => [
            'zh_CN' => '七牛云状态',
            'en'    => 'Qiniu Cloud Status',
        ],
        'input_type'    => SystemConfigInputType::SWITCH,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group'      => 'sms',
        'key'        => 'sms_qiniu_sort_order',
        'value'      => 1,
        'value_cast' => AsInteger::class,
        'name'       => [
            'zh_CN' => '七牛云优先级',
            'en'    => 'Qiniu Cloud Priority',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_qiniu_secret_key',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛云SecretKey',
            'en'    => 'Qiniu Cloud Secret Key',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    [
        'group' => 'sms',
        'key'   => 'sms_qiniu_access_key',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛云AccessKey',
            'en'    => 'Qiniu Cloud Access Key',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => 'sms_gateways',
        'input_attr'    => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | 策略
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'sms',
        'key'   => 'sms_strategy',
        'value' => OrderStrategy::class,
        'name'  => [
            'zh_CN' => '策略',
            'en'    => 'Strategy',
        ],
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '顺序', 'value' => OrderStrategy::class],
                    ['label' => '随机', 'value' => Overtrue\EasySms\Strategies\RandomStrategy::class],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Order', 'value' => OrderStrategy::class],
                    ['label' => 'Random', 'value' => Overtrue\EasySms\Strategies\RandomStrategy::class],
                ],
            ],
        ],
    ],
];
