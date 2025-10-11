<?php

return [
    'Host' => [
        'value' => 'smtp.qq.com',
        'name'  => 'SMTP Server',

        'remark'     => '',
        'input_attr' => null,
    ],
    'Port' => [
        'value' => '465',
        'name'  => 'SMTP Port',

        'remark'     => '',
        'input_attr' => null,
    ],
    'Username' => [
        'value' => '',
        'name'  => 'SMTP Username',

        'remark'     => '',
        'input_attr' => null,
    ],
    'Password' => [
        'value' => '',
        'name'  => 'SMTP Password',

        'remark'     => '',
        'input_attr' => null,
    ],
    'SMTPSecure' => [
        'value'      => 'ssl',
        'name'       => 'SMTP Encryption',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => 'ssl', 'value' => 'ssl'],
                ['label' => 'tsl', 'value' => 'tsl'],
            ],
        ],
    ],
    'From' => [
        'value' => '',
        'name'  => 'Default Sender',

        'remark'     => 'Default sender email address',
        'input_attr' => null,
    ],
    'FromName' => [
        'value' => '',
        'name'  => 'Default Sender Name',

        'remark'     => '',
        'input_attr' => null,
    ],
    'CharSet' => [
        'name'  => 'Character Set',
        'remark'     => '',
        'input_attr' => null,
    ],
    'SMTPDebug' => [
        'name'       => 'Debug Mode',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => 'Off', 'value' => '0'],
                ['label' => 'client', 'value' => '1'],
                ['label' => 'server', 'value' => '2'],
            ],
        ],
    ],
];
