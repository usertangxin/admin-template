<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | 默认缓存存储
    |--------------------------------------------------------------------------
    |
    | 此选项控制框架将使用的默认缓存存储。如果在应用程序中运行缓存操作时未明确指定其他连接，则将使用此连接。
    |
    */

    'default' => env('CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | 缓存存储
    |--------------------------------------------------------------------------
    |
    | 在这里，您可以为应用程序定义所有缓存“存储”及其驱动程序。您甚至可以为同一个缓存驱动程序定义多个存储，以对存储在缓存中的项目类型进行分组。
    |
    | 支持的驱动程序："array"、"database"、"file"、"memcached"、
    |                    "redis"、"dynamodb"、"octane"、"null"
    |
    */

    'stores' => [

        'array' => [
            'driver'    => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver'          => 'database',
            'connection'      => env('DB_CACHE_CONNECTION'),
            'table'           => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table'      => env('DB_CACHE_LOCK_TABLE'),
        ],

        'file' => [
            'driver'    => 'file',
            'path'      => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver'        => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl'          => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host'   => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port'   => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver'          => 'redis',
            'connection'      => env('REDIS_CACHE_CONNECTION', 'cache'),
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
        ],

        'dynamodb' => [
            'driver'   => 'dynamodb',
            'key'      => env('AWS_ACCESS_KEY_ID'),
            'secret'   => env('AWS_SECRET_ACCESS_KEY'),
            'region'   => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table'    => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 缓存键前缀
    |--------------------------------------------------------------------------
    |
    | 当使用 APC、database、memcached、Redis 和 DynamoDB 缓存存储时，可能会有其他应用程序使用相同的缓存。因此，您可以为每个缓存键添加前缀以避免冲突。
    |
    */

    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache_'),

];
