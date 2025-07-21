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
        Schema::create('system_posts', function (Blueprint $table) {
            $table->comment('岗位信息表');
            $table->increments('id')->comment('主键');
            $table->string('name', 50)->nullable()->comment('岗位名称');
            $table->string('code', 100)->nullable()->comment('岗位代码');
            $table->unsignedSmallInteger('sort')->nullable()->default(0)->comment('排序');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态:dict=data_status');
            $table->string('remark')->nullable()->comment('备注');
            $table->integer('created_by')->nullable()->comment('创建者');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->dateTime('create_time')->nullable()->comment('创建时间');
            $table->dateTime('update_time')->nullable()->comment('修改时间');
            $table->dateTime('delete_time')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_post');
    }
};
