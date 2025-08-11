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
        Schema::create('user_yongjin_logs', function (Blueprint $table) {
            $table->comment('用户佣金变更表');
            $table->uuid('id')->primary()->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->decimal('yongjin', 10, 0)->comment('变更金额');
            $table->decimal('before', 10, 0)->comment('变更前');
            $table->decimal('after', 10, 0)->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->string('created_by', 36)->nullable()->comment('创建者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_yongjin_logs');
    }
};
