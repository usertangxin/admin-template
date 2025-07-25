<?php

namespace Modules\Admin\Classes\Storage\Constraint;

use Illuminate\Support\Str;
use Modules\Admin\Classes\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Classes\Service\SystemConfigService;

class FileConstraint implements UploadFileConstraintInterface
{
    public function upload_mode(): string
    {
        return 'file';
    }

    public function check($files): array
    {
        $allow_str = SystemConfigService::getInstance()->getValueByKey('upload_allow_file');
        $size = SystemConfigService::getInstance()->getValueByKey('upload_size');

        $allow = explode(',', Str::of($allow_str)->replace('/s+/', '')->toString());

        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if (! in_array($ext, $allow)) {
                throw new \Exception('文件类型只允许：' . $allow_str);
            }
            if ($file->getSize() > $size) {
                throw new \Exception('文件大小超出限制：' . $size);
            }
        }

        return $files;
    }
}
