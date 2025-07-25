<?php

namespace Modules\Admin\Models;

// use Modules\Admin\Database\Factories\SystemUploadfileFactory;

class SystemUploadfile extends AbstractSoftDelModel
{
    protected $table = 'system_uploadfiles';

    protected $fillable = [
        'storage_mode',
        'origin_name',
        'object_name',
        'hash',
        'mime_type',
        'storage_path',
        'suffix',
        'size_byte',
        'url',
    ];
}
