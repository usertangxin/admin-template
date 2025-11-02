<?php

namespace Modules\Admin\Interfaces;

/**
 * 上传文件约束接口
 *
 * 该接口定义了文件上传时对文件进行验证和约束的规范。
 * 实现该接口的类需要提供上传模式标识和文件验证逻辑，
 * 用于检查上传文件的类型、大小等是否符合系统配置的要求。
 */
interface UploadFileConstraintInterface
{
    /**
     * 获取上传模式
     *
     * 返回当前约束实例对应的上传模式标识，用于区分不同类型的文件上传约束。
     * 例如：'file'（普通文件）、'image'（图片）、'audio'（音频）、
     * 'video'（视频）、'document'（文档）等。
     *
     * @return string 上传模式标识字符串
     */
    public function upload_mode(): string;

    /**
     * 检查文件是否符合限制
     *
     * 对上传的文件进行验证，检查文件扩展名、文件大小等是否符合系统配置的限制。
     * 如果文件不符合要求，将抛出异常；如果所有文件都符合要求，则返回原文件数组。
     *
     * @param  \Illuminate\Http\UploadedFile[] $files 待检查的上传文件数组
     * @return \Illuminate\Http\UploadedFile[] 通过验证的文件数组
     *
     * @throws \Exception 当文件不符合限制时抛出异常，异常消息包含具体的限制信息
     */
    public function check($files): array;
}
