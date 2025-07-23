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
        Schema::create('crud_tests', function (Blueprint $table) {
            $table->id();
            $table->comment('CRUD功能性测试');
            $table->unsignedInteger('parent_id')->nullable()->default(0)->comment('父ID');
            $table->string('name')->nullable()->comment('名称');
            $table->string('status')->nullable()->default('normal')->comment('状态:dict=data_status');
            $table->string('test_hidden_field')->nullable()->comment('测试隐藏字段');
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
        Schema::dropIfExists('crud_tests');
    }
};
