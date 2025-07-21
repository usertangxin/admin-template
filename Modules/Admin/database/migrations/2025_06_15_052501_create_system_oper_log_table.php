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
        Schema::create('system_oper_logs', function (Blueprint $table) {
            $table->comment('操作日志表');
            $table->bigIncrements('id')->comment('主键');
            $table->string('admin_name', 20)->nullable()->index('system_oper_log_admin_name')->comment('系统管理员名');
            $table->string('app', 50)->nullable()->comment('应用名称');
            $table->string('method', 20)->nullable()->comment('请求方式');
            $table->string('router', 500)->nullable()->comment('请求路由');
            $table->string('service_name', 30)->nullable()->comment('业务名称');
            $table->string('ip', 45)->nullable()->comment('请求IP地址');
            $table->string('ip_location')->nullable()->comment('IP所属地');
            $table->text('request_data')->nullable()->comment('请求数据');
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
        Schema::dropIfExists('system_oper_log');
    }
};
