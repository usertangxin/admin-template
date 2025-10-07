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
        Schema::create('system_login_logs', function (Blueprint $table) {
            $table->comment('登录日志表');
            $table->uuid('id')->primary()->comment('主键');
            $table->string('admin_name', 20)->nullable()->index('system_login_log_admin_name')->comment('系统管理员名');
            $table->string('ip', 45)->nullable()->comment('登录IP地址');
            $table->string('ip_location')->nullable()->comment('IP所属地');
            $table->string('os', 50)->nullable()->comment('操作系统');
            $table->string('browser', 50)->nullable()->comment('浏览器');
            $table->string('status', 20)->nullable()->comment('登录状态:dict=success_or_fail');
            $table->string('message', 50)->nullable()->comment('提示消息');
            $table->dateTime('logged_at')->useCurrentOnUpdate()->useCurrent()->comment('登录时间');
            $table->string('remark')->nullable()->comment('备注');
            $table->uuid('created_by')->nullable()->comment('创建者');
            $table->uuid('updated_by')->nullable()->comment('更新者');
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
        Schema::dropIfExists('system_login_logs');
    }
};
