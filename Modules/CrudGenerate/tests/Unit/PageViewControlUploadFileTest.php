<?php

namespace Modules\CrudGenerate\Tests\Unit;

use Modules\CrudGenerate\Classes\PageViewControlUploadFile;
use Modules\CrudGenerate\Models\SystemCrudHistory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageViewControlUploadFileTest extends TestCase
{
    #[DataProvider('formCodeFragmentProvider')]
    public function test_get_form_code_fragment(array $params, array $expectedStrings)
    {
        $class = $this->app->make(PageViewControlUploadFile::class);
        $class->make([
            'field_name'                       => 'file',
            'comment'                          => '文件上传',
            'page_view_control_special_params' => $params,
        ], [], new SystemCrudHistory);

        $fragment = $class->getFormCodeHtmlFragment();

        foreach ($expectedStrings as $expected) {
            $this->assertStringContainsString($expected, $fragment);
        }
    }

    public static function formCodeFragmentProvider()
    {
        return [
            'upload file basic' => [
                [],
                ['upload-file', 'v-model="formData.file"'],
            ],
            'upload file with multiple' => [
                ['multiple' => true],
                [' multiple'],
            ],
            'upload file with multiple and limit' => [
                ['multiple' => true, 'limit' => 5],
                [' multiple', ' :limit="5"'],
            ],
            'upload file with remark' => [
                ['remark' => '请上传PDF文件'],
                [':remark="\'请上传PDF文件\'"'],
            ],
            'upload file with accept' => [
                ['accept' => '.pdf,.doc,.docx'],
                [':accept="\'.pdf,.doc,.docx\'"'],
            ],
            'upload file with file size limit' => [
                ['file_size' => 10],
                [' :file-size="10"'],
            ],
            'upload file with storage mode' => [
                ['storage_mode' => 'local'],
                [':storage-mode="\'local\'"'],
            ],
            'upload file with upload mode' => [
                ['upload_mode' => 'local'],
                [':upload-mode="\'local\'"'],
            ],
            'upload file with all attributes' => [
                [
                    'multiple'     => true,
                    'limit'        => 3,
                    'remark'       => '最多上传3个图片文件',
                    'accept'       => 'image/*',
                    'file_size'    => 5,
                    'storage_mode' => 'cloud',
                    'upload_mode'  => 'normal',
                ],
                [
                    ' multiple',
                    ' :limit="3"',
                    ':remark="\'最多上传3个图片文件\'"',
                    ':accept="\'image/*\'"',
                    ' :file-size="5"',
                    ':storage-mode="\'cloud\'"',
                    ':upload-mode="\'normal\'"',
                ],
            ],
            'upload file with empty string params' => [
                [
                    'remark'       => '',
                    'accept'       => '',
                    'storage_mode' => '',
                    'upload_mode'  => '',
                ],
                ['upload-file', 'v-model="formData.file"'],
            ],
            'upload file with multiple but no limit' => [
                ['multiple' => true, 'limit' => null],
                [' multiple'],
            ],
        ];
    }
}
