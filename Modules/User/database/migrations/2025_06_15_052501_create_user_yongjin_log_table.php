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
            $table->uuid('user_id')->comment('用户编号');
            $table->decimal('yongjin', 15)->comment('变更金额');
            $table->decimal('before', 15)->comment('变更前');
            $table->decimal('after', 15)->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->datetimes();
            $table->uuid('created_by')->nullable()->comment('创建者');
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
