<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_uploadfiles', function (Blueprint $table) {
            $table->comment('附件管理表');
            $table->uuid('id')->primary()->comment('主键');
            $table->string('storage_mode')->nullable()->default('public')->comment('存储模式:dict=upload_mode');
            $table->string('upload_mode')->nullable()->default('file')->comment('上传模式:dict=upload_mode');
            $table->string('origin_name')->nullable()->comment('原文件名');
            $table->string('object_name', 50)->nullable()->comment('新文件名');
            $table->string('hash', 64)->nullable()->index('system_uploadfiles_hash')->comment('文件hash');
            $table->string('mime_type')->nullable()->comment('附件类型');
            $table->string('storage_path', 100)->nullable()->index('system_uploadfile_storage_path')->comment('存储目录');
            $table->string('suffix', 10)->nullable()->comment('文件后缀');
            $table->string('origin_suffix', 10)->nullable()->comment('客户端文件后缀');
            $table->unsignedBigInteger('size_byte')->nullable()->comment('字节数');
            $table->string('url')->nullable()->comment('url地址');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('created_by', 36)->nullable()->comment('创建者');
            $table->string('updated_by', 36)->nullable()->comment('更新者');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('修改时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_uploadfiles');
    }
};
