<?php

namespace Modules\Admin\Interfaces;

use DateTime;

/**
 * 上传文件存储接口
 * 实现在存储应该 laravel 提供者 boot 方法中注册进 FileStorageService
 *
 * @see \Modules\Admin\Classes\Service\FileStorageService
 */
interface UploadFileStorageInterface
{
    /**
     * 获取存储模式
     */
    public function storage_mode(): string;

    /**
     * 存储文件
     *
     * @param \Illuminate\Http\UploadedFile[] $files
     * @param string                          $upload_mode 上传模式
     * @param string                          $path        路径
     */
    public function storage($files, $upload_mode, $path = ''): array;

    /**
     * 删除文件
     *
     * @param mixed $paths
     */
    public function delete($paths): bool;

    /**
     * 生成临时路径
     *
     * @param mixed $path
     * @param array $options
     */
    public function temporaryUrl($path, DateTime $expiration, $options = []): string;
}
