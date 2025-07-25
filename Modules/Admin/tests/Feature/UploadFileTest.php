<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadFileTest extends AbstractAuthTestCase
{
    public function test_uploadfile()
    {
        $response = $this->postJson('/web/admin/SystemUploadFile/upload', [
            'file' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertJson(['code' => 0]);
    }
}
