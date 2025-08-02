<?php

namespace Modules\Admin\Classes\Storage\Constraint;

use Illuminate\Support\Str;
use Modules\Admin\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Services\SystemConfigService;

class AudioConstraint implements UploadFileConstraintInterface
{
    public function upload_mode(): string
    {
        return 'audio';
    }

    public function check($files): array
    {
        $allow_str = SystemConfigService::getInstance()->getValueByKey('upload_allow_audio');
        $size      = SystemConfigService::getInstance()->getValueByKey('upload_size_audio');

        $allow = explode(',', Str::of($allow_str)->replace('/s+/', '')->toString());

        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if (! in_array($ext, $allow)) {
                throw new \Exception('音频类型只允许：' . $allow_str);
            }
            if ($file->getSize() > $size) {
                throw new \Exception('音频大小超出限制：' . $size);
            }
        }

        return $files;
    }
}
