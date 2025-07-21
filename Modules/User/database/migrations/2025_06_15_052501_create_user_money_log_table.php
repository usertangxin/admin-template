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
        Schema::create('user_money_logs', function (Blueprint $table) {
            $table->comment('用户余额变更表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->decimal('money', 15)->comment('变更金额');
            $table->decimal('before', 15)->comment('变更前');
            $table->decimal('after', 15)->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->unsignedInteger('created_by')->nullable()->comment('创建者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_money_logs');
    }
};
