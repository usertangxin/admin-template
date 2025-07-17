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
        Schema::create('system_login_log', function (Blueprint $table) {
            $table->comment('登录日志表');
            $table->increments('id')->comment('主键');
            $table->string('admin_name', 20)->nullable()->index('system_login_log_admin_name')->comment('系统管理员名');
            $table->string('ip', 45)->nullable()->comment('登录IP地址');
            $table->string('ip_location')->nullable()->comment('IP所属地');
            $table->string('os', 50)->nullable()->comment('操作系统');
            $table->string('browser', 50)->nullable()->comment('浏览器');
            $table->string('status', 20)->nullable()->comment('登录状态:dict=success_or_fail');
            $table->string('message', 50)->nullable()->comment('提示消息');
            $table->dateTime('login_time')->useCurrentOnUpdate()->useCurrent()->comment('登录时间');
            $table->string('remark')->nullable()->comment('备注');
            $table->integer('created_by')->nullable()->comment('创建者');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->dateTime('create_time')->nullable()->comment('创建时间');
            $table->dateTime('update_time')->nullable()->comment('更新时间');
            $table->dateTime('delete_time')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_login_log');
    }
};
