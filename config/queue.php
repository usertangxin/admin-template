<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 默认队列连接名称
    |--------------------------------------------------------------------------
    |
    | Laravel 的队列通过单一、统一的 API 支持多种后端，让你可以使用相同的语法
    | 方便地访问每个后端。下面定义了默认的队列连接。
    |
    */

    'default' => env('QUEUE_CONNECTION', 'database'),

    /*
    |--------------------------------------------------------------------------
    | 队列连接
    |--------------------------------------------------------------------------
    |
    | 在这里，你可以为应用程序使用的每个队列后端配置连接选项。
    | 为 Laravel 支持的每个后端提供了示例配置。你也可以自由添加更多配置。
    |
    | 驱动："sync"、"database"、"beanstalkd"、"sqs"、"redis"、"null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION'),
            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            'queue' => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => env('BEANSTALKD_QUEUE_HOST', 'localhost'),
            'queue' => env('BEANSTALKD_QUEUE', 'default'),
            'retry_after' => (int) env('BEANSTALKD_QUEUE_RETRY_AFTER', 90),
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
            'block_for' => null,
            'after_commit' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 作业批处理
    |--------------------------------------------------------------------------
    |
    | 以下选项配置存储作业批处理信息的数据库和表。这些选项可以更新为
    | 应用程序定义的任何数据库连接和表。
    |
    */

    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'job_batches',
    ],

    /*
    |--------------------------------------------------------------------------
    | 失败的队列作业
    |--------------------------------------------------------------------------
    |
    | 这些选项配置失败队列作业日志记录的行为，以便你可以控制失败作业的存储方式和位置。
    | Laravel 支持将失败作业存储在简单文件或数据库中。
    |
    | 支持的驱动："database-uuids"、"dynamodb"、"file"、"null"
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'failed_jobs',
    ],

];
