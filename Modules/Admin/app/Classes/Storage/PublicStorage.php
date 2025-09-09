<?php

namespace Modules\Admin\Classes\Storage;

use DateTime;
use Illuminate\Filesystem\LocalFilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Admin\Interfaces\UploadFileStorageInterface;
use Modules\Admin\Models\SystemUploadFile;
use Modules\Admin\Services\SystemConfigService;

class PublicStorage implements UploadFileStorageInterface
{
    protected function getConfig(): array
    {
        $systemConfigService = SystemConfigService::getInstance();
        try {
            $domain = $systemConfigService->getValueByKey('public_domain');
        } catch (\Throwable $e) {
            $domain = '';
        }

        return [
            'driver'     => 'local',
            'root'       => storage_path('app/admin-public'),
            'url'        => $domain . '/storage-admin',
            'visibility' => 'public',
            'serve'      => false,
            'throw'      => true,
            'report'     => false,
        ];
    }

    public function __construct()
    {
        \config([
            'filesystems.disks.admin-public' => $this->getConfig(),
            'filesystems.links'              => \array_merge(
                \config('filesystems.links'),
                [
                    public_path('storage-admin') => storage_path('app/admin-public'),
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

        $public_status = $systemConfigService->getValueByKey('public_status');
        if ($public_status != 'normal') {
            throw new \Exception('本地存储未启用');
        }

        $disk = $this->getDisk();

        $arr = [];

        foreach ($files as $file) {
            $hash             = md5_file($file->getRealPath());
            $systemUploadfile = SystemUploadFile::where([
                'hash'         => $hash,
                'storage_mode' => $this->storage_mode(),
                'upload_mode'  => $upload_mode,
            ])->first();
            if ($systemUploadfile) {
                $arr[] = $systemUploadfile->toArray();
            } else {
                $base_path = $upload_mode;
                $path && $base_path .= '/' . $path;
                $path = $disk->putFile($base_path, $file);
                $data = [
                    'storage_mode'  => $this->storage_mode(),
                    'upload_mode'   => $upload_mode,
                    'origin_name'   => $file->getClientOriginalName(),
                    'object_name'   => Str::of($path)->after($base_path . '/')->toString(),
                    'hash'          => $hash,
                    'mime_type'     => $file->getMimeType(),
                    'storage_path'  => $path,
                    'suffix'        => $file->extension(),
                    'origin_suffix' => Str::of($file->getClientOriginalExtension())->lower()->toString(),
                    'size_byte'     => $file->getSize(),
                    'url'           => $disk->url($path),
                    'remark'        => request('remark'),
                ];
                SystemUploadFile::create($data);
                $arr[] = $data;
            }
        }

        return $arr;
    }

    public function delete($paths): bool
    {
        return $this->getDisk()->delete($paths);
    }

    public function temporaryUrl($path, DateTime $expiration, $options = []): string
    {
        throw new \Exception('该存储可直接访问，无需生成');
    }

    public function __call($name, $arguments)
    {
        return $this->getDisk()->$name(...$arguments);
    }
}
