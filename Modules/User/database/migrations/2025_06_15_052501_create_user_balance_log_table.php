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
        Schema::create('user_balance_logs', function (Blueprint $table) {
            $table->comment('用户余额变更表');
            $table->uuid('id')->primary()->comment('编号');
            $table->uuid('user_id')->comment('用户编号');
            $table->decimal('balance', 15)->comment('变更金额');
            $table->decimal('before', 15)->comment('变更前');
            $table->decimal('after', 15)->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->enum('operation', [
                'recharge',
                'withdraw',
                'consumption',
                'refund',
                'freeze',
                'unfreeze',
            ])->comment('操作:dict=user_balance_operation');
            $table->datetimes();
            $table->uuid('created_by')->nullable()->comment('创建者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balance_logs');
    }
};
