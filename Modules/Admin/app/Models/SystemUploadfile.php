<?php

namespace Modules\Admin\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Modules\Admin\Services\FileStorageService;

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
        'origin_suffix',
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

    #[Scope]
    protected function mime_type(Builder $query, $mime_type)
    {
        if (\strpos($mime_type, '/') !== false) {
            $query->where('mime_type', 'like', $mime_type);
        } else {
            $query->whereIn('suffix', \explode(',', $mime_type))->orWhereIn('origin_suffix', \explode(',', $mime_type));
        }
    }

    #[Scope]
    protected function object_name(Builder $query, $value)
    {
        $query->whereLike('object_name', "%$value%")->orWhereLike('origin_name', "%$value%");
    }

    #[Scope]
    protected function size_byte(Builder $query, $value)
    {
        if (is_array($value)) {
            if (!is_null(($value[0] ?? null))) {
                $query->where('size_byte', '>=', $value[0]);
            }
            if (!is_null(($value[1] ?? null))) {
                $query->where('size_byte', '<=', $value[1]);
            }
        } else {
            $query->where('size_byte', '<=', $value);
        }
    }

    #[Scope]
    protected function fast_search(Builder $query, $value)
    {
        $query->whereLike('object_name', "%$value%")->orWhereLike('origin_name', "%$value%");
    }

    #[Scope]
    protected function ids(Builder $query, $ids)
    {
        $query->whereIn('id', $ids);
    }
}
