<?php

namespace Modules\Admin\Classes\Storage\Constraint;

use Illuminate\Support\Str;
use Modules\Admin\Classes\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Classes\Service\SystemConfigService;

class VideoConstraint implements UploadFileConstraintInterface
{
    public function upload_mode(): string
    {
        return 'video';
    }

    public function check($files): array
    {
        $allow = SystemConfigService::getInstance()->getValueByKey('upload_allow_video');
        $size = SystemConfigService::getInstance()->getValueByKey('upload_size_video');

        $allow = explode(',', Str::of($allow)->replace('/s+/', '')->toString());

        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if (! in_array($ext, $allow)) {
                throw new \Exception('视频类型只允许：' . $allow);
            }
            if ($file->getSize() > $size) {
                throw new \Exception('视频大小超出限制：' . $size);
            }
        }

        return $files;
    }
}
