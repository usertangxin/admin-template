<?php

namespace Modules\Admin\Classes\Storage;

use Illuminate\Filesystem\LocalFilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Admin\Classes\Interfaces\UploadFileStorageInterface;
use Modules\Admin\Classes\Service\SystemConfigService;
use Modules\Admin\Models\SystemUploadfile;

class PublicStorage implements UploadFileStorageInterface
{
    public function storage_mode(): string
    {
        return 'public';
    }

    public function getDisk(): LocalFilesystemAdapter
    {
        return Storage::build([
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'throw'      => false,
            'report'     => false,
        ]);
    }

    public function storage($files, $upload_mode): array
    {
        $systemConfigService = SystemConfigService::getInstance();
        $domain = $systemConfigService->getValueByKey('public_domain');

        $disk = $this->getDisk();

        $arr = [];

        foreach ($files as $file) {
            $hash = md5_file($file->getRealPath());
            $systemUploadfile = SystemUploadfile::where(['hash' => $hash, 'storage_mode' => $this->storage_mode()])->first();
            if ($systemUploadfile) {
                $arr[] = $systemUploadfile->toArray();
            } else {
                $path = $disk->putFile($upload_mode, $file);
                $data = [
                    'storage_mode' => $this->storage_mode(),
                    'origin_name'  => $file->getClientOriginalName(),
                    'object_name'  => Str::of($path)->after($upload_mode . '/')->toString(),
                    'hash'         => $hash,
                    'mime_type'    => $file->getMimeType(),
                    'storage_path' => 'storage/' . $path,
                    'suffix'       => $file->getClientOriginalExtension(),
                    'size_byte'    => $file->getSize(),
                    'url'          => $domain . '/storage/' . $path,
                ];
                SystemUploadfile::create($data);
                $arr[] = $data;
            }
        }

        return $arr;
    }

    public function delete($path): bool
    {
        $disk = $this->getDisk();

        return $disk->delete($path);
    }
}
