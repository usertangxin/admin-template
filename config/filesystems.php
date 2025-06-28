<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 默认文件系统磁盘
    |--------------------------------------------------------------------------
    |
    | 在这里你可以指定框架应使用的默认文件系统磁盘。 "local" 磁盘以及各种基于云的磁盘
    | 都可供你的应用程序用于文件存储。
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | 文件系统磁盘
    |--------------------------------------------------------------------------
    |
    | 你可以根据需要配置任意数量的文件系统磁盘，甚至可以为同一个驱动程序配置多个磁盘。
    | 这里配置了大多数受支持的存储驱动程序的示例供参考。
    |
    | 支持的驱动程序: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app/private'),
            'serve'  => true,
            'throw'  => false,
            'report' => false,
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw'      => false,
            'report'     => false,
        ],

        's3' => [
            'driver'                  => 's3',
            'key'                     => env('AWS_ACCESS_KEY_ID'),
            'secret'                  => env('AWS_SECRET_ACCESS_KEY'),
            'region'                  => env('AWS_DEFAULT_REGION'),
            'bucket'                  => env('AWS_BUCKET'),
            'url'                     => env('AWS_URL'),
            'endpoint'                => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw'                   => false,
            'report'                  => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 符号链接
    |--------------------------------------------------------------------------
    |
    | 在这里你可以配置在执行 `storage:link` Artisan 命令时将创建的符号链接。数组键应该是
    | 链接的位置，值应该是它们的目标。
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
