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
        Schema::create('user_integral_logs', function (Blueprint $table) {
            $table->comment('用户积分变更记录表');
            $table->uuid('id')->primary()->comment('编号');
            $table->uuid('user_id')->comment('用户编号');
            $table->integer('integral')->comment('变更数量');
            $table->integer('before')->comment('变更前');
            $table->integer('after')->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->enum('operation', [
                'consumption_returns_integral',
                'deduction',
                'freeze',
                'unfreeze',
            ])->comment('操作:user_integral_operation');
            $table->timestamps();
            $table->uuid('created_by')->nullable()->comment('创建者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_integral_logs');
    }
};
