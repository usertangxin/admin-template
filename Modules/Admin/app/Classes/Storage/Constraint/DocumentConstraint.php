<?php

namespace Modules\Admin\Classes\Storage\Constraint;

use Illuminate\Support\Str;
use Modules\Admin\Classes\Interfaces\UploadFileConstraintInterface;
use Modules\Admin\Classes\Service\SystemConfigService;

class DocumentConstraint implements UploadFileConstraintInterface
{
    public function upload_mode(): string
    {
        return 'document';
    }

    public function check($files): array
    {
        $allow_str = SystemConfigService::getInstance()->getValueByKey('upload_allow_document');
        $size      = SystemConfigService::getInstance()->getValueByKey('upload_size_document');

        $allow = explode(',', Str::of($allow_str)->replace('/s+/', '')->toString());

        foreach ($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if (! in_array($ext, $allow)) {
                throw new \Exception('文档类型只允许：' . $allow_str);
            }
            if ($file->getSize() > $size) {
                throw new \Exception('文档大小超出限制：' . $size);
            }
        }

        return $files;
    }
}
