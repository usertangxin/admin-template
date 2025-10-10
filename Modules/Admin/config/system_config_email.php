<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group'      => 'email_config',
        'key'        => 'Host',
        'value'      => 'smtp.qq.com',
        'name'       => 'SMTP服务器',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'      => 'email_config',
        'key'        => 'Port',
        'value'      => '465',
        'name'       => 'SMTP端口',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'      => 'email_config',
        'key'        => 'Username',
        'value'      => '',
        'name'       => 'SMTP用户名',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'      => 'email_config',
        'key'        => 'Password',
        'value'      => '',
        'name'       => 'SMTP密码',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'         => 'email_config',
        'key'           => 'SMTPSecure',
        'value'         => 'ssl',
        'name'          => 'SMTP验证方式',
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => [
            'options' => [['label' => 'ssl', 'value' => 'ssl'], ['label' => 'tsl', 'value' => 'tsl']],
        ],
    ],
    [
        'group'      => 'email_config',
        'key'        => 'From',
        'value'      => '',
        'name'       => '默认发件人',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '默认发件的邮箱地址',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'      => 'email_config',
        'key'        => 'FromName',
        'value'      => '',
        'name'       => '默认发件名称',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'      => 'email_config',
        'key'        => 'CharSet',
        'value'      => 'UTF-8',
        'name'       => '编码',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group'         => 'email_config',
        'key'           => 'SMTPDebug',
        'value'         => '0',
        'name'          => '调试模式',
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => null,
        'input_attr'    => [
            'options' => [['label' => '关闭', 'value' => '0'], ['label' => 'client', 'value' => '1'], ['label' => 'server', 'value' => '2']],
        ],
    ],
];
