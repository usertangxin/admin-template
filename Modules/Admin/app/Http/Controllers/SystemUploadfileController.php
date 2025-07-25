<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Service\UploadFileService;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemUploadfile;

#[SystemMenu('附件管理', icon: 'fas file', parent_code: 'system.basic')]
class SystemUploadFileController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null
    {
        return new SystemUploadfile();
    }

    #[SystemMenu('上传文件')]
    public function postUpload(UploadFileService $uploadFileService)
    {
        $arr = $uploadFileService->upload();
        // \dd($arr);
        return $this->success($arr);
    }
}
