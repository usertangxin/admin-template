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
        Schema::create('user_login_logs', function (Blueprint $table) {
            $table->comment('用户登录日志');
            $table->uuid('id')->primary()->comment('主键');
            $table->string('username', 20)->nullable()->comment('用户名');
            $table->string('ip', 45)->nullable()->comment('登录IP地址');
            $table->string('ip_location')->nullable()->comment('IP所属地');
            $table->string('os', 50)->nullable()->comment('操作系统');
            $table->string('browser', 50)->nullable()->comment('浏览器');
            $table->string('status')->nullable()->comment('登录状态:dict=success_or_fail');
            $table->string('message', 50)->nullable()->comment('提示消息');
            $table->dateTime('logged_at')->useCurrentOnUpdate()->useCurrent()->comment('登录时间');
            $table->string('remark')->nullable()->comment('备注');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->string('login_type')->nullable()->comment('登录方式');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_login_logs');
    }
};
