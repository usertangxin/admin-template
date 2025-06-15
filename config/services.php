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
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
