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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('用户表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('parent_id')->default(0)->comment('上级编号');
            $table->text('level')->nullable()->comment('关系层级');
            $table->string('nickname', 191)->nullable()->comment('昵称');
            $table->string('username', 191)->unique('username')->comment('用户名');
            $table->string('phone', 191)->nullable()->unique('phone')->comment('手机号');
            $table->string('email', 191)->nullable()->unique('email')->comment('邮箱');
            $table->string('password')->nullable()->comment('密码');
            $table->decimal('yongjin', 15)->unsigned()->default(0)->comment('佣金');
            $table->decimal('yongjin_freeze', 15)->unsigned()->default(0)->comment('冻结佣金');
            $table->decimal('money', 15)->unsigned()->default(0)->comment('余额');
            $table->decimal('money_freeze', 15)->unsigned()->default(0)->comment('冻结余额');
            $table->unsignedInteger('score')->default(0)->comment('积分');
            $table->unsignedInteger('score_freeze')->default(0)->comment('冻结积分');
            $table->string('sex')->default('unknown')->comment('性别:dict=sex');
            $table->string('avatar')->nullable()->comment('头像');
            $table->dateTime('birthday')->nullable()->comment('生日');
            $table->unsignedInteger('vip')->default(0)->comment('会员等级');
            $table->string('last_login_ip')->nullable()->comment('最后登录IP');
            $table->string('last_login_type')->nullable()->comment('最后登录方式');
            $table->boolean('status')->nullable()->default(true)->comment('状态:dict=data_status');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->string('mini_openid')->nullable()->comment('小程序openid');
            $table->string('official_openid')->nullable()->comment('公众号openid');
            $table->string('alipay_name')->nullable()->comment('支付宝账户姓名');
            $table->string('alipay_account')->nullable()->comment('支付宝账户');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
