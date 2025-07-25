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
        $allow = SystemConfigService::getInstance()->getValueByKey('upload_allow_file');
        $size = SystemConfigService::getInstance()->getValueByKey('upload_size');

        $allow = explode(',', Str::of($allow)->replace('/s+/', '')->toString());
        
        foreach($files as $file) {
            $ext = $file->getClientOriginalExtension();
            if(!in_array($ext, $allow)) {
                throw new \Exception('文件类型不允许');
            }
            if($file->getSize() > $size) {
                throw new \Exception('文件大小超出限制');
            }
        }

        return $files;
    }
}
