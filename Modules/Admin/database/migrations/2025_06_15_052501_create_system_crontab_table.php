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
        Schema::create('system_crontab', function (Blueprint $table) {
            $table->comment('定时任务信息表');
            $table->increments('id')->comment('主键');
            $table->string('name', 100)->nullable()->comment('任务名称');
            $table->smallInteger('type')->nullable()->default(4)->comment('任务类型 (1 command, 2 class, 3 url, 4 eval)');
            $table->string('target', 500)->nullable()->comment('调用任务字符串');
            $table->string('parameter', 1000)->nullable()->comment('调用任务参数');
            $table->string('rule', 32)->nullable()->comment('任务执行表达式');
            $table->smallInteger('singleton')->nullable()->default(1)->comment('是否单次执行 (1 是 2 不是)');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态 (1正常 2停用)');
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
        Schema::dropIfExists('system_crontab');
    }
};
