<?php

namespace Modules\Admin\Services;

use DateTime;
use Modules\Admin\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Interfaces\UploadFileStorageInterface;
use Modules\Admin\Models\SystemUploadFile;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class FileStorageService
{
    /**
     * 文件限制
     *
     * @var array<string, UploadFileConstraintInterface>
     */
    protected array $file_constraint = [];

    /**
     * 文件存储
     *
     * @var array<string, UploadFileStorageInterface>
     */
    protected array $file_storage = [];

    public static function getInstance(): static
    {
        return \app(static::class);
    }

    public function registerFileConstraint(UploadFileConstraintInterface $constraint)
    {
        $this->file_constraint[$constraint->upload_mode()] = $constraint;
    }

    public function registerFileStorage(UploadFileStorageInterface $storage)
    {
        $this->file_storage[$storage->storage_mode()] = $storage;
    }

    public function upload($path = '')
    {
        $storage_mode = \request('storage_mode', SystemConfigService::getInstance()->getValueByKey('storage_mode'));
        $upload_mode  = \request('upload_mode', 'file');
        $files        = \request()->file('file');
        if (empty($files)) {
            throw new NotFoundResourceException('请上传文件');
        }
        $constraint = $this->file_constraint[$upload_mode] ?? null;
        if (empty($constraint)) {
            throw new NotFoundResourceException('上传模式不存在');
        }
        $storage = $this->file_storage[$storage_mode] ?? null;
        if (empty($storage)) {
            throw new NotFoundResourceException('存储模式不存在');
        }
        if (! \is_array($files)) {
            $files = [$files];
        }
        $files = $constraint->check($files);
        // 过滤掉 $path 中所有敏感字符串
        $sensitiveStrings = ['../', '..\\', './', '.\\', '~', '|', ';', '&', '`', '$', '<', '>', '?', '*', '"', "'", '{', '}', '[', ']'];
        foreach ($sensitiveStrings as $sensitiveString) {
            $path = str_replace($sensitiveString, '', $path);
        }
        $result = $storage->storage($files, $upload_mode, $path);

        return $result;
    }

    public function delete($ids)
    {
        if (! \is_array($ids)) {
            $ids = \explode(',', $ids);
        }
        /** @var SystemUploadFile[] $systemUploadFiles */
        $systemUploadFiles = SystemUploadFile::withTrashed()->whereIn('id', $ids)->get();
        $success_paths     = [];
        $fail_paths        = [];
        foreach ($systemUploadFiles as $systemUploadFile) {
            $storage = $this->file_storage[$systemUploadFile->storage_mode] ?? null;
            if (empty($storage)) {
                continue;
            }
            if ($storage->delete($systemUploadFile->storage_path)) {
                $success_paths[] = $systemUploadFile->storage_path;
            } else {
                $fail_paths[] = $systemUploadFile->storage_path;
            }
        }

        return [
            'success_paths' => $success_paths,
            'fail_paths'    => $fail_paths,
        ];
    }

    public function temporaryUrl($id, DateTime $expiration)
    {
        /** @var SystemUploadFile $systemUploadFile */
        $systemUploadFile = SystemUploadFile::withTrashed()->find($id);
        if (empty($systemUploadFile)) {
            throw new NotFoundResourceException('文件不存在');
        }
        $storage = $this->file_storage[$systemUploadFile->storage_mode] ?? null;
        if (empty($storage)) {
            throw new NotFoundResourceException('存储模式不存在');
        }

        // \dump($systemUploadFile->storage_path);
        return $storage->temporaryUrl($systemUploadFile->storage_path, $expiration);
    }
}
