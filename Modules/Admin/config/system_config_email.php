<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group' => 'email_config',
        'key'   => 'Host',
        'value' => 'smtp.qq.com',
        'name'  => [
            'zh_CN' => 'SMTP服务器',
            'en'    => 'SMTP Server',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'Port',
        'value' => '465',
        'name'  => [
            'zh_CN' => 'SMTP端口',
            'en'    => 'SMTP Port',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'Username',
        'value' => '',
        'name'  => [
            'zh_CN' => 'SMTP用户名',
            'en'    => 'SMTP Username',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'Password',
        'value' => '',
        'name'  => [
            'zh_CN' => 'SMTP密码',
            'en'    => 'SMTP Password',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'SMTPSecure',
        'value' => 'ssl',
        'name'  => [
            'zh_CN' => 'SMTP验证方式',
            'en'    => 'SMTP Authentication Method',
        ],
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => [
            'zh_CN' => ['options' => [['label' => 'ssl', 'value' => 'ssl'], ['label' => 'tsl', 'value' => 'tsl']]],
            'en'    => ['options' => [['label' => 'ssl', 'value' => 'ssl'], ['label' => 'tsl', 'value' => 'tsl']]],
        ],
    ],
    [
        'group' => 'email_config',
        'key'   => 'From',
        'value' => '',
        'name'  => [
            'zh_CN' => '默认发件人',
            'en'    => 'Default Sender',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '默认发件的邮箱地址',
            'en'    => 'Default Sender Email Address',
        ],
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'FromName',
        'value' => '',
        'name'  => [
            'zh_CN' => '默认发件名称',
            'en'    => 'Default Sender Name',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'CharSet',
        'value' => 'UTF-8',
        'name'  => [
            'zh_CN' => '编码',
            'en'    => 'Character Set',
        ],
        'input_type'    => SystemConfigInputType::INPUT,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'email_config',
        'key'   => 'SMTPDebug',
        'value' => '0',
        'name'  => [
            'zh_CN' => '调试模式',
            'en'    => 'Debug Mode',
        ],
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => [
            'zh_CN' => ['options' => [['label' => '关闭', 'value' => '0'], ['label' => 'client', 'value' => '1'], ['label' => 'server', 'value' => '2']]],
            'en'    => ['options' => [['label' => 'Off', 'value' => '0'], ['label' => 'client', 'value' => '1'], ['label' => 'server', 'value' => '2']]],
        ],
    ],
];
