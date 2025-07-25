<?php

namespace Modules\Admin\Classes\Storage\Constraint;

use Illuminate\Support\Str;
use Modules\Admin\Classes\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Classes\Service\SystemConfigService;

class AudioConstraint implements UploadFileConstraintInterface
{
    public function upload_mode(): string
    {
        return 'audio';
    }

    public function check($files): array
    {
        $allow = SystemConfigService::getInstance()->getValueByKey('upload_allow_audio');
        $size = SystemConfigService::getInstance()->getValueByKey('upload_size_audio');

        $allow = explode(',', Str::of($allow)->replace('/s+/', '')->toString());

        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if (! in_array($ext, $allow)) {
                throw new \Exception('音频类型只允许：' . $allow);
            }
            if ($file->getSize() > $size) {
                throw new \Exception('音频大小超出限制：' . $size);
            }
        }

        return $files;
    }
}
