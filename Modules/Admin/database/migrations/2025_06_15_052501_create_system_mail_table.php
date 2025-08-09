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
        Schema::create('system_mails', function (Blueprint $table) {
            $table->comment('邮件记录');
            $table->uuid('id')->primary()->comment('编号');
            $table->string('gateway', 50)->nullable()->comment('网关');
            $table->string('from', 50)->nullable()->comment('发送人');
            $table->string('email', 50)->nullable()->comment('接收人');
            $table->string('code', 20)->nullable()->comment('验证码');
            $table->string('content', 500)->nullable()->comment('邮箱内容');
            $table->string('status', 20)->nullable()->comment('发送状态');
            $table->string('response', 500)->nullable()->comment('返回结果');
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
        Schema::dropIfExists('system_mails');
    }
};
