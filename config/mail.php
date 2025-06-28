<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 默认邮件驱动
    |--------------------------------------------------------------------------
    |
    | 此选项控制用于发送所有电子邮件的默认邮件驱动，除非在发送邮件时明确指定了其他邮件驱动。
    | 所有额外的邮件驱动可以在 "mailers" 数组中配置。已提供各种邮件驱动的示例。
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | 邮件驱动配置
    |--------------------------------------------------------------------------
    |
    | 在这里，您可以配置应用程序使用的所有邮件驱动及其各自的设置。已经为您配置了几个示例，
    | 您可以根据应用程序的需求添加自己的配置。
    |
    | Laravel 支持多种在发送电子邮件时使用的邮件 "传输" 驱动。
    | 您可以在下面指定您要为邮件驱动使用的驱动。如果需要，您还可以添加额外的邮件驱动。
    |
    | 支持的驱动: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport'    => 'smtp',
            'scheme'       => env('MAIL_SCHEME'),
            'url'          => env('MAIL_URL'),
            'host'         => env('MAIL_HOST', '127.0.0.1'),
            'port'         => env('MAIL_PORT', 2525),
            'username'     => env('MAIL_USERNAME'),
            'password'     => env('MAIL_PASSWORD'),
            'timeout'      => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path'      => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers'   => [
                'smtp',
                'log',
            ],
            'retry_after' => 60,
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers'   => [
                'ses',
                'postmark',
            ],
            'retry_after' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 全局 "发件人" 地址
    |--------------------------------------------------------------------------
    |
    | 您可能希望应用程序发送的所有电子邮件都使用同一个发件人地址。
    | 在这里，您可以指定一个全局用于应用程序发送的所有电子邮件的名称和地址。
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name'    => env('MAIL_FROM_NAME', 'Example'),
    ],

];
