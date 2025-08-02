<?php

namespace Modules\Admin\Interfaces;

interface UploadFileConstraintInterface
{
    /**
     * 获取上传模式
     */
    public function upload_mode(): string;

    /**
     * 检查文件是否符合限制
     *
     * @param  \Illuminate\Http\UploadedFile[] $files
     * @return \Illuminate\Http\UploadedFile[]
     */
    public function check($files): array;
}
