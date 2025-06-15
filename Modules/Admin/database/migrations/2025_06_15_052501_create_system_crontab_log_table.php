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
        Schema::create('system_crontab_log', function (Blueprint $table) {
            $table->comment('定时任务执行日志表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('crontab_id')->nullable()->comment('任务ID');
            $table->string('name')->nullable()->comment('任务名称');
            $table->string('target', 500)->nullable()->comment('任务调用目标字符串');
            $table->string('parameter', 1000)->nullable()->comment('任务调用参数');
            $table->string('exception_info', 2000)->nullable()->comment('异常信息');
            $table->smallInteger('status')->nullable()->default(1)->comment('执行状态 (1成功 2失败)');
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
        Schema::dropIfExists('system_crontab_log');
    }
};
