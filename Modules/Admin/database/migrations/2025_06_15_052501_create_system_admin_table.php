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
            $table->comment('用户信息表');
            $table->increments('id')->comment('用户ID,主键');
            $table->string('adminname', 20)->unique('adminname')->comment('用户名');
            $table->string('password', 100)->comment('密码');
            $table->string('admin_type', 3)->nullable()->default('100')->comment('用户类型:(100系统用户)');
            $table->string('nickname', 30)->nullable()->comment('用户昵称');
            $table->string('phone', 11)->nullable()->comment('手机');
            $table->string('email', 50)->nullable()->comment('用户邮箱');
            $table->string('avatar')->nullable()->default('/avatar.png')->comment('用户头像');
            $table->string('signed')->nullable()->comment('个人签名');
            $table->string('dashboard', 100)->nullable()->comment('后台首页类型');
            $table->unsignedInteger('dept_id')->nullable()->index('dept_id')->comment('部门ID');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态 (1正常 2停用)');
            $table->string('login_ip', 45)->nullable()->comment('最后登陆IP');
            $table->dateTime('login_time')->nullable()->comment('最后登陆时间');
            $table->string('backend_setting', 500)->nullable()->comment('后台设置数据');
            $table->text('remark')->nullable()->comment('备注');
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
