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
        Schema::create('system_crud_histories', function (Blueprint $table) {
            $table->comment('系统CRUD操作历史表');
            $table->uuid('id')->primary()->comment('主键');

            $table->string('table_comment', 50)->nullable()->comment('表注释');
            $table->string('table_name', 50)->comment('表名');
            $table->json('file_list')->nullable()->comment('文件列表');
            $table->enum('gen_mode', ['app', 'module'])->default('app')->comment('生成方式');
            $table->string('gen_class_name')->comment('生成的类名');
            $table->string('module_name', 50)->nullable()->comment('模块名');
            $table->json('index_list')->nullable()->comment('数据表索引列表');
            $table->json('column_list')->nullable()->comment('数据表字段列表');
            $table->boolean('soft_delete')->default(true)->comment('是否软删除');
            $table->string('parent_menu_code')->nullable()->comment('父菜单编码');
            $table->string('menu_code')->nullable()->comment('菜单编码');
            $table->string('menu_name')->nullable()->comment('菜单名称');
            $table->string('menu_icon')->nullable()->comment('菜单图标');

            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_crud_histories');
    }
};
