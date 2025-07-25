<?php

namespace Modules\Admin\Classes\Service;

use Modules\Admin\Classes\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Classes\Interfaces\UploadFileStorageInterface;

class UploadFileService
{
    /**
     * 文件限制
     *
     * @var array<string, UploadFileConstraintInterface>
     */
    protected $file_constraint = [
        // 'file' => [
        //     'allow' => 'upload_allow_file',
        //     'size' => 'upload_size'
        // ],
        // 'image' => [
        //     'allow' => 'upload_allow_image',
        //     'size' => 'upload_size_image'
        // ],
        // 'video' => [
        //     'allow' => 'upload_allow_video',
        //     'size' => 'upload_size_video'
        // ],
        // 'audio' => [
        //     'allow' => 'upload_allow_audio',
        //     'size' => 'upload_size_audio'
        // ],
        // 'document' => [
        //     'allow' => 'upload_allow_document',
        //     'size' => 'upload_size_document'
        // ],
    ];

    /**
     * 文件存储
     *
     * @var array<string, UploadFileStorageInterface>
     */
    protected $file_storage = [];

    public function registerFileConstraint(UploadFileConstraintInterface $constraint)
    {
        $this->file_constraint[$constraint->upload_mode()] = $constraint;
    }

    public function registerFileStorage(UploadFileStorageInterface $storage)
    {
        $this->file_storage[$storage->storage_mode()] = $storage;
    }

    public function upload()
    {
        $storage_mode = \request('storage_mode', SystemConfigService::getInstance()->getValueByKey('storage_mode'));
        $upload_mode = \request('upload_mode', 'file');
        $files = \request()->file('file');
        if (empty($files)) {
            throw new \Exception('请上传文件');
        }
        $constraint = $this->file_constraint[$upload_mode] ?? null;
        if (empty($constraint)) {
            throw new \Exception('上传模式不存在');
        }
        $storage = $this->file_storage[$storage_mode] ?? null;
        if (empty($storage)) {
            throw new \Exception('存储模式不存在');
        }
        if (! \is_array($files)) {
            $files = [$files];
        }
        $files = $constraint->check($files);
        $result = $storage->storage($files, $upload_mode);

        // \dd($result);
        return $result;
    }
}
