<?php

namespace Modules\Admin\Models;

use Modules\Admin\Classes\Service\FileStorageService;

// use Modules\Admin\Database\Factories\SystemUploadfileFactory;

class SystemUploadfile extends AbstractSoftDelModel
{
    protected $table = 'system_uploadfiles';

    protected $fillable = [
        'storage_mode',
        'upload_mode',
        'origin_name',
        'object_name',
        'hash',
        'mime_type',
        'storage_path',
        'suffix',
        'size_byte',
        'url',
    ];

    protected static function booted()
    {
        static::forceDeleting(function ($model) {
            $fileStorageService = FileStorageService::getInstance();
            $fileStorageService->delete($model->id);
        });
    }
}
