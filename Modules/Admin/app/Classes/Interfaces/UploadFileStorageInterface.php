<?php

namespace Modules\Admin\Classes\Interfaces;

interface UploadFileStorageInterface
{
    /**
     * 获取存储模式
     */
    public function storage_mode(): string;

    public function getDisk(): \Illuminate\Filesystem\LocalFilesystemAdapter;

    /**
     * 存储文件
     *
     * @param \Illuminate\Http\UploadedFile[] $files
     * @param string                          $upload_mode 上传模式
     */
    public function storage($files, $upload_mode): array;

    public function delete($path): bool;
}
