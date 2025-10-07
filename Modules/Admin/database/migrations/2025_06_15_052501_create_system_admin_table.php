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
        Schema::create('system_admins', function (Blueprint $table) {
            $table->comment('系统管理员信息表');
            $table->uuid('id')->primary()->comment('系统管理员ID,主键');
            $table->string('admin_name', 20)->unique('system_admin_admin_name')->comment('系统管理员名');
            $table->string('password', 100)->comment('密码');
            $table->string('nickname', 30)->nullable()->comment('系统管理员昵称');
            $table->string('phone', 50)->nullable()->comment('手机');
            $table->string('email', 50)->nullable()->comment('系统管理员邮箱');
            $table->string('avatar')->nullable()->default('/avatar.png')->comment('系统管理员头像');
            $table->string('dashboard', 100)->nullable()->comment('后台首页类型');
            $table->string('data_scope_name', 100)->nullable()->comment('边界名称');
            $table->string('status')->nullable()->default('normal')->comment('状态:dict=data_status');
            $table->string('login_ip', 45)->nullable()->comment('最后登陆IP');
            $table->dateTime('logged_at')->nullable()->comment('最后登陆时间');
            $table->string('backend_setting', 500)->nullable()->comment('后台设置数据');
            $table->text('remark')->nullable()->comment('备注');
            $table->rememberToken()->nullable()->comment('记住我');
            $table->boolean('is_root')->default(false)->comment('根管理员');
            $table->json('extend_data_scope')->nullable()->comment('扩展数据权限配置');
            $table->uuid('created_by')->nullable()->comment('创建者');
            $table->uuid('updated_by')->nullable()->comment('更新者');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('修改时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_admins');
    }
};
