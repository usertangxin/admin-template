<?php

namespace App\Providers;

use Illuminate\Filesystem\FilesystemServiceProvider as IlluminateFilesystemServiceProvider;

/**
 * 将其置于最后执行加载最新磁盘路由
 */
class FilesystemServiceProvider extends IlluminateFilesystemServiceProvider
{
    //
}
