<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 第三方服务
    |--------------------------------------------------------------------------
    |
    | 此文件用于存储第三方服务（如 Mailgun、Postmark、AWS 等）的凭证。
    | 该文件是此类信息的实际存储位置，让各个包可以通过这个约定俗成的文件
    | 来查找各种服务的凭证。
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key'     => env('AWS_ACCESS_KEY_ID'),
        'secret'  => env('AWS_SECRET_ACCESS_KEY'),
        'region'  => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'version' => 'latest',
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'easy-sms' => [
        // HTTP 请求的超时时间（秒）
        'timeout' => 5.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => [
                // 'yunpian', 'aliyun',
            ],
        ],
        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => '/tmp/easy-sms.log',
            ],
            // 'yunpian' => [
            //     'api_key' => env('EASY_SMS_YUNPIAN_API_KEY'),
            // ],
            // 'aliyun' => [
            //     'access_key_id' => env('EASY_SMS_ALIYUN_KEY_ID'),
            //     'access_key_secret' =>  env('EASY_SMS_ALIYUN_API_KEY'),
            //     'sign_name' => '',
            // ],
            // ...
        ],
    ],

];
