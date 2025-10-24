<?php

namespace Modules\FileStorageExtend\Classes\Storage;

use DateTime;
use Exception;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Admin\Interfaces\UploadFileStorageInterface;
use Modules\Admin\Models\SystemUploadFile;
use Modules\Admin\Services\SystemConfigService;

class CosStorage implements UploadFileStorageInterface
{
    protected function getConfig(): array
    {
        $systemConfigService = SystemConfigService::getInstance();
        try {
            $app_id     = $systemConfigService->getValueByKey('upload_cos_appId');
            $secret_id  = $systemConfigService->getValueByKey('upload_cos_secretId');
            $secret_key = $systemConfigService->getValueByKey('upload_cos_secretKey');
            $region     = $systemConfigService->getValueByKey('upload_cos_region');
            $bucket     = $systemConfigService->getValueByKey('upload_cos_bucket');
            $domain     = $systemConfigService->getValueByKey('upload_cos_domain');
        } catch (\Throwable $e) {
            $app_id     = '';
            $secret_id  = '';
            $secret_key = '';
            $region     = '';
            $bucket     = '';
            $domain     = '';
        }

        return [
            'driver'     => 'qiniu',
            'app_id'     => $app_id,
            'secret_id'  => $secret_id,
            'secret_key' => $secret_key,
            'region'     => $region,
            'bucket'     => $bucket,
            'domain'     => $domain,
            'throw'      => true,
        ];
    }

    public function __construct()
    {
        config([
            'filesystems.disks.admin-qiniu' => $this->getConfig(),
        ]);
    }

    public function storage_mode(): string
    {
        return 'upload_qiniu';
    }

    protected function getDisk(): FilesystemAdapter
    {
        return Storage::disk('admin-qiniu');
    }

    public function storage($files, $upload_mode, $path = ''): array
    {
        $systemConfigService = SystemConfigService::getInstance();

        $qiniu_status = $systemConfigService->getValueByKey('upload_qiniu_status');
        if ($qiniu_status != 'normal') {
            throw new Exception(__('admin::system_upload_file.upload_status_disabled'));
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

    public function temporaryUrl($path, DateTime $expiration, $options = []): string
    {
        return $this->getDisk()->temporaryUrl($path, $expiration, $options);
    }

    public function __call($name, $arguments)
    {
        return $this->getDisk()->$name(...$arguments);
    }
}
