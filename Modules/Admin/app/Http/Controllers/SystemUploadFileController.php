<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemUploadFile;
use Modules\Admin\Services\FileStorageService;

#[SystemMenu('附件管理', icon: 'fas file', parent_code: 'system.basic')]
class SystemUploadFileController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null
    {
        return new SystemUploadFile;
    }

    #[SystemMenu('上传文件')]
    public function postUpload(FileStorageService $fileStorageService)
    {
        $arr = $fileStorageService->upload();

        // \dd($arr);
        return $this->success($arr, __('admin::system_upload_file.upload_success'));
    }

    #[SystemMenu('图片上传')]
    public function postImageUpload(FileStorageService $fileStorageService)
    {
        request()->merge([
            'upload_mode' => 'image',
        ]);
        $arr = $fileStorageService->upload();

        // \dd($arr);
        return $this->success($arr, __('admin::system_upload_file.upload_success'));
    }

    #[SystemMenu('视频上传')]
    public function postVideoUpload(FileStorageService $fileStorageService)
    {
        request()->merge([
            'upload_mode' => 'video',
        ]);
        $arr = $fileStorageService->upload();

        // \dd($arr);
        return $this->success($arr, __('admin::system_upload_file.upload_success'));
    }

    #[SystemMenu('音频上传')]
    public function postAudioUpload(FileStorageService $fileStorageService)
    {
        request()->merge([
            'upload_mode' => 'audio',
        ]);
        $arr = $fileStorageService->upload();

        // \dd($arr);
        return $this->success($arr, __('admin::system_upload_file.upload_success'));
    }

    #[SystemMenu('文稿上传')]
    public function postDocumentUpload(FileStorageService $fileStorageService)
    {
        request()->merge([
            'upload_mode' => 'document',
        ]);
        $arr = $fileStorageService->upload();

        // \dd($arr);
        return $this->success($arr, __('admin::system_upload_file.upload_success'));
    }

    #[SystemMenu('获取临时链接')]
    public function getTemporaryUrl(FileStorageService $fileStorageService)
    {
        $id         = request('id');
        $expiration = request('expiration', 3600);
        $url        = $fileStorageService->temporaryUrl($id, new \DateTime('+' . $expiration . ' seconds'));

        return $this->success(['url' => $url]);
    }

    #[SystemMenu('生成公开存储软链')]
    public function postGenSymlink()
    {
        Artisan::call('storage:link');

        return $this->success(message: __('admin::system_upload_file.gen_symlink_success'));
    }
}
