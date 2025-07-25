<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Http\UploadedFile;

class UploadFileTest extends AbstractAuthTestCase
{
    public function test_uploadfile()
    {

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => '',
        ]);
        $response->assertJson(['message' => '请上传文件']);

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => UploadedFile::fake()->image('test.jpg'),
            'upload_mode' => 'asdf',
        ]);
        $response->assertJson(['message' => '上传模式不存在']);

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertJson(['code' => 0]);

        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => UploadedFile::fake()->image('test.png'),
            'upload_mode' => 'document',
        ]);
        $this->assertTrue(\str_contains($response->json('message'), '文档类型只允许'));
        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => UploadedFile::fake()->create('test.md', 12485760),
            'upload_mode' => 'document',
        ]);
        $this->assertTrue(\str_contains($response->json('message'), '文档大小超出限制'));
    }
}
