<?php

namespace Modules\FileStorageExtend\Classes\Storage;

use DateTime;
use Exception;
use Illuminate\Filesystem\LocalFilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Admin\Interfaces\UploadFileStorageInterface;
use Modules\Admin\Models\SystemUploadFile;
use Modules\Admin\Services\SystemConfigService;

class OSSStorage implements UploadFileStorageInterface
{
    protected function getConfig(): array
    {
        $systemConfigService = SystemConfigService::getInstance();
        try {
            $prefix = $systemConfigService->getValueByKey('upload_oss_dirname');
            $accessKeyId = $systemConfigService->getValueByKey('upload_oss_accessKeyId');
            $accessKeySecret = $systemConfigService->getValueByKey('upload_oss_accessKeySecret');
            $endpoint = $systemConfigService->getValueByKey('upload_oss_endpoint');
            $bucket = $systemConfigService->getValueByKey('upload_oss_bucket');
            $isCName = $systemConfigService->getValueByKey('upload_oss_domain');
        } catch (\Throwable $e) {
            $prefix = '';
            $accessKeyId = '';
            $accessKeySecret = '';
            $endpoint = '';
            $bucket = '';
            $isCName = false;
        }

        return [
            'driver' => 'oss',
            'prefix' => $prefix,
            'accessKeyId' => $accessKeyId,
            'accessKeySecret' => $accessKeySecret,
            'endpoint' => $endpoint,
            'bucket' => $bucket,
            'isCName' => $isCName,
            'serve'  => true,
            'throw'  => true,
        ];
    }

    public function __construct()
    {
        config([
            'filesystems.disks.admin-oss' => $this->getConfig(),
        ]);
    }

    public function storage_mode(): string
    {
        return 'oss';
    }

    protected function getDisk(): LocalFilesystemAdapter
    {
        return Storage::disk('admin-oss');
    }

    public function storage($files, $upload_mode, $path = ''): array 
    {
        $systemConfigService = SystemConfigService::getInstance();

        $oss_status = $systemConfigService->getValueByKey('upload_oss_status');
        if ($oss_status != 'normal') {
            throw new Exception(__('file_storage_extend::system_upload_file.upload_oss_status'));
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
                    'url'           => $path,
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

    public function temporaryUrl($path, DateTime $expiration, $options = []): string {
        return $this->getDisk()->temporaryUrl($path, $expiration, $options);
    }

    public function __call($name, $arguments)
    {
        return $this->getDisk()->$name(...$arguments);
    }
}
