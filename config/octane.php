<?php

use Laravel\Octane\Contracts\OperationTerminated;
use Laravel\Octane\Events\RequestHandled;
use Laravel\Octane\Events\RequestReceived;
use Laravel\Octane\Events\RequestTerminated;
use Laravel\Octane\Events\TaskReceived;
use Laravel\Octane\Events\TaskTerminated;
use Laravel\Octane\Events\TickReceived;
use Laravel\Octane\Events\TickTerminated;
use Laravel\Octane\Events\WorkerErrorOccurred;
use Laravel\Octane\Events\WorkerStarting;
use Laravel\Octane\Events\WorkerStopping;
use Laravel\Octane\Listeners\CloseMonologHandlers;
use Laravel\Octane\Listeners\CollectGarbage;
use Laravel\Octane\Listeners\DisconnectFromDatabases;
use Laravel\Octane\Listeners\EnsureUploadedFilesAreValid;
use Laravel\Octane\Listeners\EnsureUploadedFilesCanBeMoved;
use Laravel\Octane\Listeners\FlushOnce;
use Laravel\Octane\Listeners\FlushTemporaryContainerInstances;
use Laravel\Octane\Listeners\FlushUploadedFiles;
use Laravel\Octane\Listeners\ReportException;
use Laravel\Octane\Listeners\StopWorkerIfNecessary;
use Laravel\Octane\Octane;

return [

    /*
    |--------------------------------------------------------------------------
    | Octane 服务器
    |--------------------------------------------------------------------------
    |
    | 此值决定 Octane 通过 CLI 启动、重启或停止服务器时将使用的默认 "服务器"。
    | 你可以自由地将其更改为你选择的受支持服务器。
    |
    | 支持: "roadrunner", "swoole", "frankenphp"
    |
    */

    'server' => env('OCTANE_SERVER', 'frankenphp'),

    /*
    |--------------------------------------------------------------------------
    | 强制使用 HTTPS
    |--------------------------------------------------------------------------
    |
    | 当此配置值设置为 "true" 时，Octane 将通知框架所有绝对链接必须使用 HTTPS 协议生成。
    | 否则，你的链接可能会使用普通 HTTP 生成。
    |
    */

    'https' => env('OCTANE_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Octane 监听器
    |--------------------------------------------------------------------------
    |
    | 以下定义了 Octane 事件的所有事件监听器。这些监听器负责为下一个请求重置应用程序的状态。
    | 你甚至可以向列表中添加自己的监听器。
    |
    */

    'listeners' => [
        WorkerStarting::class => [
            EnsureUploadedFilesAreValid::class,
            EnsureUploadedFilesCanBeMoved::class,
        ],

        RequestReceived::class => [
            ...Octane::prepareApplicationForNextOperation(),
            ...Octane::prepareApplicationForNextRequest(),
            //
        ],

        RequestHandled::class => [
            //
        ],

        RequestTerminated::class => [
            // FlushUploadedFiles::class,
        ],

        TaskReceived::class => [
            ...Octane::prepareApplicationForNextOperation(),
            //
        ],

        TaskTerminated::class => [
            //
        ],

        TickReceived::class => [
            ...Octane::prepareApplicationForNextOperation(),
            //
        ],

        TickTerminated::class => [
            //
        ],

        OperationTerminated::class => [
            FlushOnce::class,
            FlushTemporaryContainerInstances::class,
            // DisconnectFromDatabases::class,
            // CollectGarbage::class,
        ],

        WorkerErrorOccurred::class => [
            ReportException::class,
            StopWorkerIfNecessary::class,
        ],

        WorkerStopping::class => [
            CloseMonologHandlers::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 预热 / 刷新绑定
    |--------------------------------------------------------------------------
    |
    | 以下列出的绑定将在工作进程启动时进行预预热，或者在每个新请求之前刷新。
    | 刷新绑定将强制容器在被请求时再次解析该绑定。
    |
    */

    'warm' => [
        ...Octane::defaultServicesToWarm(),
    ],

    'flush' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Octane Swoole 表
    |--------------------------------------------------------------------------
    |
    | 在使用 Swoole 时，你可以根据应用程序的需要定义额外的表。
    | 这些表可用于存储特定 Swoole 服务器上其他工作进程需要快速访问的数据。
    |
    */

    'tables' => [
        'example:1000' => [
            'name'  => 'string:1000',
            'votes' => 'int',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Octane Swoole 缓存表
    |--------------------------------------------------------------------------
    |
    | 在使用 Swoole 时，你可以利用 Octane 缓存，它由 Swoole 表提供支持。
    | 你可以使用以下配置选项设置最大行数以及每行的字节数。
    |
    */

    'cache' => [
        'rows'  => 1000,
        'bytes' => 10000,
    ],

    /*
    |--------------------------------------------------------------------------
    | 文件监听
    |--------------------------------------------------------------------------
    |
    | 以下文件和目录列表将在使用 Octane 提供的 --watch 选项时被监听。
    | 如果任何目录和文件发生更改，Octane 将自动重新加载你的工作进程。
    |
    */

    'watch' => [
        'app',
        'bootstrap',
        'config/**/*.php',
        'database/**/*.php',
        'public/**/*.php',
        'resources/**/*.php',
        'routes',
        'composer.lock',
        '.env',
    ],

    /*
    |--------------------------------------------------------------------------
    | 垃圾回收阈值
    |--------------------------------------------------------------------------
    |
    | 在执行 Octane 等长时间运行的 PHP 脚本时，内存可能会在被 PHP 清除之前累积。
    | 如果你的应用程序消耗了此数量的兆字节，你可以强制 Octane 运行垃圾回收。
    |
    */

    'garbage' => 50,

    /*
    |--------------------------------------------------------------------------
    | 最大执行时间
    |--------------------------------------------------------------------------
    |
    | 以下设置配置了 Octane 处理请求的最大执行时间。
    | 你可以将此值设置为 0 以表示 Octane 请求执行时间没有特定的时间限制。
    |
    */

    'max_execution_time' => 30,

];
