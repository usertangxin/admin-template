<?php

namespace Modules\Admin\Classes\Storage;

use DateTime;
use Exception;
use Illuminate\Filesystem\LocalFilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Modules\Admin\Interfaces\UploadFileStorageInterface;
use Modules\Admin\Models\SystemUploadFile;
use Modules\Admin\Services\SystemConfigService;

class PrivateStorage implements UploadFileStorageInterface
{
    protected function getConfig(): array
    {
        // $systemConfigService = SystemConfigService::getInstance();
        // $domain              = $systemConfigService->getValueByKey('public_domain');

        return [
            'driver' => 'local',
            'root'   => storage_path('app/admin-private'),
            'url'    => 'storage-admin-private',
            'serve'  => true,
            'throw'  => true,
            'report' => false,
        ];
    }

    public function __construct()
    {
        config([
            'filesystems.disks.admin-private' => $this->getConfig(),
        ]);
        Storage::disk('admin-private')->buildTemporaryUrlsUsing(
            function (string $path, DateTime $expiration, array $options) {
                return URL::to(URL::temporarySignedRoute(
                    'storage.admin-private',
                    $expiration,
                    array_merge($options, ['path' => $path]),
                    false,
                ));
            }
        );
    }

    public function storage_mode(): string
    {
        return 'private';
    }

    protected function getDisk(): LocalFilesystemAdapter
    {
        return Storage::disk('admin-private');
    }

    public function storage($files, $upload_mode, $path = ''): array
    {
        $systemConfigService = SystemConfigService::getInstance();

        $public_status = $systemConfigService->getValueByKey('private_status');
        if ($public_status != 'normal') {
            throw new Exception(__('admin::system_upload_file.upload_private_status'));
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
