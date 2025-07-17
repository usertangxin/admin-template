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
        Schema::create('system_admin', function (Blueprint $table) {
            $table->comment('系统管理员信息表');
            $table->increments('id')->comment('系统管理员ID,主键');
            $table->string('admin_name', 20)->unique('system_admin_admin_name')->comment('系统管理员名');
            $table->string('password', 100)->comment('密码');
            $table->string('nickname', 30)->nullable()->comment('系统管理员昵称');
            $table->string('phone', 11)->nullable()->comment('手机');
            $table->string('email', 50)->nullable()->comment('系统管理员邮箱');
            $table->string('avatar')->nullable()->default('/avatar.png')->comment('系统管理员头像');
            $table->string('dashboard', 100)->nullable()->comment('后台首页类型');
            $table->unsignedInteger('dept_id')->nullable()->index('system_admin_dept_id')->comment('部门ID');
            $table->string('status')->nullable()->default('normal')->comment('状态:dict=data_status');
            $table->string('login_ip', 45)->nullable()->comment('最后登陆IP');
            $table->dateTime('login_time')->nullable()->comment('最后登陆时间');
            $table->string('backend_setting', 500)->nullable()->comment('后台设置数据');
            $table->text('remark')->nullable()->comment('备注');
            $table->string('remember_token', 100)->nullable()->comment('记住我');
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
        Schema::dropIfExists('system_admin');
    }
};
