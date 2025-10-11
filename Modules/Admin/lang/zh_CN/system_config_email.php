<?php

return [
    'Host' => [
        'name'  => 'SMTP服务器',

        'remark'     => '',
        'input_attr' => null,
    ],
    'Port' => [
        'name'  => 'SMTP端口',

        'remark'     => '',
        'input_attr' => null,
    ],
    'Username' => [
        'name'  => 'SMTP用户名',

        'remark'     => '',
        'input_attr' => null,
    ],
    'Password' => [
        'name'  => 'SMTP密码',

        'remark'     => '',
        'input_attr' => null,
    ],
    'SMTPSecure' => [
        'name'       => 'SMTP验证方式',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => 'ssl', 'value' => 'ssl'],
                ['label' => 'tsl', 'value' => 'tsl'],
            ],
        ],
    ],
    'From' => [
        'name'  => '默认发件人',

        'remark'     => '默认发件的邮箱地址',
        'input_attr' => null,
    ],
    'FromName' => [
        'name'  => '默认发件名称',

        'remark'     => '',
        'input_attr' => null,
    ],
    'CharSet' => [
        'name'  => '编码',

        'remark'     => '',
        'input_attr' => null,
    ],
    'SMTPDebug' => [
        'name'       => '调试模式',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => '关闭', 'value' => '0'],
                ['label' => 'client', 'value' => '1'],
                ['label' => 'server', 'value' => '2'],
            ],
        ],
    ],
];
