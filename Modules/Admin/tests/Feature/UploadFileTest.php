<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Services\SystemConfigService;

class UploadFileTest extends AbstractAuthTestCase
{
    public function test_uploadfile()
    {

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => '',
        ]);
        $response->assertJson(['message' => '请上传文件']);

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file'        => UploadedFile::fake()->image('test.jpg'),
            'upload_mode' => 'asdf',
        ]);
        $response->assertJson(['message' => '上传模式不存在']);

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertJson(['code' => 0]);
        $this->assertTrue(Storage::disk('public')->delete($response->json('data.0.storage_path')));

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file'        => UploadedFile::fake()->image('test.png'),
            'upload_mode' => 'document',
        ]);
        $this->assertTrue(\str_contains($response->json('message'), '文档类型只允许'));
        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file'        => UploadedFile::fake()->create('test.md', 12485760),
            'upload_mode' => 'document',
        ]);
        $this->assertTrue(\str_contains($response->json('message'), '文档大小超出限制'));
    }

    public function test_public_disabled()
    {
        $this->postJson('/web/admin/SystemConfig/save', [
            'data' => [
                [
                    'key'   => 'public_status',
                    'value' => 'disabled',
                ],
            ],
        ]);
        $systemConfigService = SystemConfigService::getInstance();
        $systemConfigService->refresh();
        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file'        => UploadedFile::fake()->create('test.md', 1),
            'upload_mode' => 'document',
        ]);
        $this->assertTrue(\str_contains($response->json('message'), '本地存储未启用'));
    }

    public function test_temporary_url_public()
    {
        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file'        => UploadedFile::fake()->create('test.md', 1),
            'upload_mode' => 'document',
        ]);

        $response = $this->getJson('/web/admin/SystemUploadFile/temporary-url?id=1&expiration=1');
        $this->assertTrue(\str_contains($response->json('message'), '该存储可直接访问，无需生成'));
    }

    public function test_temporary_url_private()
    {
        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file'         => UploadedFile::fake()->create('test.md', 1),
            'upload_mode'  => 'document',
            'storage_mode' => 'private',
        ]);

        $response = $this->getJson('/web/admin/SystemUploadFile/temporary-url?id=1&expiration=1');
        $response->assertJson(['code' => 0]);

        $this->assertTrue(\str_contains($response->json('data.url'), 'http'));

        $response = $this->get($response->json('data.url'));

        $response->assertStatus(200);

    }
}
