<?php

namespace Modules\Admin\Classes\Storage\Constraint;

use Illuminate\Support\Str;
use Modules\Admin\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Services\SystemConfigService;

class ImageConstraint implements UploadFileConstraintInterface
{
    public function upload_mode(): string
    {
        return 'image';
    }

    public function check($files): array
    {
        $allow_str = SystemConfigService::getInstance()->getValueByKey('upload_allow_image');
        $size      = SystemConfigService::getInstance()->getValueByKey('upload_size_image');

        $allow = explode(',', Str::of($allow_str)->replace('/s+/', '')->toString());

        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if (! in_array($ext, $allow)) {
                throw new \Exception(__('admin::system_upload_file.upload_allow_image') . '：' . $allow_str);
            }
            if ($file->getSize() > $size) {
                throw new \Exception(__('admin::system_upload_file.upload_size_image') . '：' . $size);
            }
        }

        return $files;
    }
}
