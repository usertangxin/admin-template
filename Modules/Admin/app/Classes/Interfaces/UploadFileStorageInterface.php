<?php

namespace Modules\Admin\Classes\Interfaces;

interface UploadFileStorageInterface
{
    /**
     * 获取存储模式
     * 
     * @return string 
     */
    public function storage_mode(): string;

    /**
     * 存储文件
     * 
     * @param \Illuminate\Http\UploadedFile[] $files 
     * @param string $upload_mode 上传模式
     * @return array 
     */
    public function storage($files, $upload_mode): array;
}
