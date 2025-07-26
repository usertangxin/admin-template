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
    protected function getConfig(): array
    {
        return [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'visibility' => 'public',
            'throw'      => true,
            'report'     => false,
        ];
    }

    public function __construct()
    {
        \config([
            'filesystems.disks.public' => $this->getConfig(),
            'filesystems.links'        => \array_merge(
                \config('filesystems.links'),
                [
                    public_path('storage') => storage_path('app/public'),
                ]
            ),
        ]);
    }

    public function storage_mode(): string
    {
        return 'public';
    }

    protected function getDisk(): LocalFilesystemAdapter
    {
        return Storage::build($this->getConfig());
    }

    public function storage($files, $upload_mode, $path = ''): array
    {
        $systemConfigService = SystemConfigService::getInstance();
        $domain              = $systemConfigService->getValueByKey('public_domain');

        $disk = $this->getDisk();

        $arr = [];

        foreach ($files as $file) {
            $hash             = md5_file($file->getRealPath());
            $systemUploadfile = SystemUploadfile::where(['hash' => $hash, 'storage_mode' => $this->storage_mode()])->first();
            if ($systemUploadfile) {
                $arr[] = $systemUploadfile->toArray();
            } else {
                $path = $disk->putFile($upload_mode . '/' . $path, $file);
                $data = [
                    'storage_mode' => $this->storage_mode(),
                    'origin_name'  => $file->getClientOriginalName(),
                    'object_name'  => Str::of($path)->after($upload_mode . '/')->toString(),
                    'hash'         => $hash,
                    'mime_type'    => $file->getMimeType(),
                    'storage_path' => $path,
                    'suffix'       => $file->extension(),
                    'size_byte'    => $file->getSize(),
                    'url'          => $domain . '/storage/' . $path,
                ];
                SystemUploadfile::create($data);
                $arr[] = $data;
            }
        }

        return $arr;
    }

    public function delete($paths): bool
    {
        return $this->getDisk()->delete($paths);
    }

    public function __call($name, $arguments)
    {
        return $this->getDisk()->$name(...$arguments);
    }
}
